import { create } from './api';
import { Notification, Booking, Room, CleaningTask, User, Owner } from './supabase-types';
import { supabase } from '../integrations/supabase';

// Interface for notification payload
interface NotificationPayload {
  title: string;
  message: string;
  user_id?: string;
  role?: string;
}

/**
 * Creates a notification for a specific user
 */
export async function createUserNotification(
  userId: string,
  title: string,
  message: string
): Promise<Notification> {
  const notification = await create<Notification>('notifications', {
    user_id: userId,
    title,
    message,
    is_read: false,
    created_at: new Date().toISOString(),
  });

  return notification;
}

/**
 * Creates notifications for all users with a specific role
 */
export async function createRoleNotification(
  role: string,
  title: string,
  message: string
): Promise<void> {
  // Get all users with the specified role
  const { data: users, error } = await supabase
    .from('users')
    .select('id')
    .eq('role', role);

  if (error) {
    console.error('Error fetching users for role notification:', error);
    throw error;
  }

  // Create notifications for each user
  for (const user of users) {
    await createUserNotification(user.id, title, message);
  }
}

/**
 * Creates a notification for a booking event
 */
export async function createBookingNotification(
  booking: Booking,
  eventType: 'created' | 'updated' | 'cancelled' | 'checked-in' | 'checked-out'
): Promise<void> {
  let title = '';
  let message = '';
  const roomInfo = booking.rooms ? `Room ${booking.rooms.number}` : 'a room';

  switch (eventType) {
    case 'created':
      title = 'New Booking';
      message = `New booking #${booking.booking_number} for ${booking.guest_name} has been created.`;
      break;
    case 'updated':
      title = 'Booking Updated';
      message = `Booking #${booking.booking_number} for ${booking.guest_name} has been updated.`;
      break;
    case 'cancelled':
      title = 'Booking Cancelled';
      message = `Booking #${booking.booking_number} for ${booking.guest_name} has been cancelled.`;
      break;
    case 'checked-in':
      title = 'Guest Checked In';
      message = `${booking.guest_name} has checked in to room ${booking.rooms?.number || 'unknown'}.`;
      break;
    case 'checked-out':
      title = 'Guest Checked Out';
      message = `${booking.guest_name} has checked out from room ${booking.rooms?.number || 'unknown'}.`;
      break;
  }

  // Notify all managers and admins
  await createRoleNotification('admin', title, message);
  await createRoleNotification('manager', title, message);
  
  // Also notify the owner of the room
  if (booking.room_id) {
    const { data: ownership, error } = await supabase
      .from('property_ownership')
      .select('owner_id')
      .eq('room_id', booking.room_id)
      .single();
    
    if (!error && ownership && ownership.owner_id) {
      // Get the owner's user ID
      const { data: ownerUser, error: ownerError } = await supabase
        .from('users')
        .select('id')
        .eq('role', 'owner')
        .eq('email', (await supabase.from('owners').select('email').eq('id', ownership.owner_id).single()).data?.email)
        .single();
      
      if (!ownerError && ownerUser) {
        await createUserNotification(ownerUser.id, title, message);
      }
    }
  }
}

/**
 * Creates a notification for cleaning tasks
 */
export async function createCleaningNotification(
  task: CleaningTask,
  eventType: 'created' | 'completed' | 'assigned'
): Promise<void> {
  let title = '';
  let message = '';
  
  const roomInfo = task.rooms ? `Room ${task.rooms.number}` : `Room ID: ${task.room_id}`;
  
  switch (eventType) {
    case 'created':
      title = 'New Cleaning Task';
      message = `New cleaning task has been created for room ${task.rooms?.number || 'unknown'}.`;
      break;
    case 'completed':
      title = 'Cleaning Task Completed';
      message = `Cleaning task for room ${task.rooms?.number || 'unknown'} has been completed.`;
      break;
    case 'assigned':
      title = 'Cleaning Task Assigned';
      message = `You have been assigned a cleaning task for room ${task.rooms?.number || 'unknown'}.`;
      break;
  }
  
  // Create notification for admin users if created or completed
  if (event !== 'assigned') {
    try {
      const { data: adminUsers, error } = await supabase
        .from('users')
        .select('id')
        .eq('role', 'admin');
      
      if (error) {
        console.error('Error fetching admin users:', error);
        return;
      }
      
      // Create a notification for each admin user
      for (const user of adminUsers || []) {
        await createNotification(user.id, title, message);
      }
    } catch (error) {
      console.error('Error creating cleaning notification for admins:', error);
    }
  }
  
  // Create notification for assigned user
  if (task.assigned_to && event === 'assigned') {
    await createNotification(task.assigned_to, title, message);
  }
}

/**
 * Creates a notification for maintenance events
 */
export async function createMaintenanceNotification(
  maintenance: any,
  eventType: 'new' | 'updated' | 'completed'
): Promise<void> {
  let title = '';
  let message = '';
  
  switch (eventType) {
    case 'new':
      title = 'New Maintenance Issue';
      message = `A new maintenance issue has been reported for Room ${maintenance.room_id}: ${maintenance.description}`;
      break;
    case 'updated':
      title = 'Maintenance Update';
      message = `Maintenance task for Room ${maintenance.room_id} has been updated`;
      break;
    case 'completed':
      title = 'Maintenance Completed';
      message = `Maintenance task for Room ${maintenance.room_id} has been completed`;
      break;
  }
  
  // Notify all managers and maintenance staff
  await createRoleNotification('manager', title, message);
  await createRoleNotification('maintenance', title, message);
}

/**
 * Creates a system-wide announcement notification
 */
export async function createAnnouncementNotification(
  title: string,
  message: string,
  roles?: string[]
): Promise<void> {
  if (roles && roles.length > 0) {
    // Send to specific roles only
    for (const role of roles) {
      await createRoleNotification(role, title, message);
    }
  } else {
    // Send to all users
    const { data: users, error } = await supabase
      .from('users')
      .select('id');
    
    if (error) {
      console.error('Error fetching users for announcement:', error);
      throw error;
    }
    
    for (const user of users) {
      await createUserNotification(user.id, title, message);
    }
  }
}

/**
 * Creates a notification in the database
 */
export async function createNotification(
  userId: string | null,
  title: string,
  message: string
): Promise<void> {
  try {
    const { error } = await supabase
      .from('notifications')
      .insert({
        user_id: userId,
        title,
        message,
        is_read: false,
        created_at: new Date().toISOString()
      });
    
    if (error) {
      console.error('Error creating notification:', error);
    }
  } catch (error) {
    console.error('Error creating notification:', error);
  }
}

/**
 * Creates a notification for room-related events
 */
export async function createRoomNotification(room: Room, event: 'maintenance' | 'available'): Promise<void> {
  let title = '';
  let message = '';
  
  switch (event) {
    case 'maintenance':
      title = 'Room Under Maintenance';
      message = `Room ${room.number} at ${room.properties?.name || 'property'} is now under maintenance.`;
      break;
    case 'available':
      title = 'Room Available';
      message = `Room ${room.number} at ${room.properties?.name || 'property'} is now available.`;
      break;
  }
  
  // Create notification for admin users
  try {
    const { data: adminUsers, error } = await supabase
      .from('users')
      .select('id')
      .eq('role', 'admin');
    
    if (error) {
      console.error('Error fetching admin users:', error);
      return;
    }
    
    // Create a notification for each admin user
    for (const user of adminUsers || []) {
      await createNotification(user.id, title, message);
    }
    
    // Notify owners
    if (room.id) {
      // Find the owner of this room
      const { data: ownership, error: ownershipError } = await supabase
        .from('property_ownership')
        .select('owner_id')
        .eq('room_id', room.id)
        .single();
      
      if (!ownershipError && ownership && ownership.owner_id) {
        // Find user account associated with this owner
        const { data: ownerUser, error: ownerUserError } = await supabase
          .from('users')
          .select('id')
          .eq('email', ownership.owner_id)
          .single();
        
        if (!ownerUserError && ownerUser) {
          await createNotification(
            ownerUser.id, 
            title, 
            `Your property: ${message}`
          );
        }
      }
    }
  } catch (error) {
    console.error('Error creating room notification:', error);
  }
}

/**
 * Mark a notification as read
 */
export async function markNotificationAsRead(id: string): Promise<void> {
  try {
    const { error } = await supabase
      .from('notifications')
      .update({ is_read: true })
      .eq('id', id);
    
    if (error) {
      console.error('Error marking notification as read:', error);
    }
  } catch (error) {
    console.error('Error marking notification as read:', error);
  }
}

/**
 * Mark all notifications for a user as read
 */
export async function markAllNotificationsAsRead(userId: string): Promise<void> {
  try {
    const { error } = await supabase
      .from('notifications')
      .update({ is_read: true })
      .eq('user_id', userId)
      .eq('is_read', false);
    
    if (error) {
      console.error('Error marking all notifications as read:', error);
    }
  } catch (error) {
    console.error('Error marking all notifications as read:', error);
  }
}

/**
 * Delete a notification
 */
export async function deleteNotification(id: string): Promise<void> {
  try {
    const { error } = await supabase
      .from('notifications')
      .delete()
      .eq('id', id);
    
    if (error) {
      console.error('Error deleting notification:', error);
    }
  } catch (error) {
    console.error('Error deleting notification:', error);
  }
}