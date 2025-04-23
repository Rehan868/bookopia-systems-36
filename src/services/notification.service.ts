
import { supabase } from '@/integrations/supabase';
import { Booking, Notification } from './supabase-types';

// Create a notification for a user
async function createUserNotification(
  userId: string, 
  title: string, 
  message: string
): Promise<Notification | null> {
  try {
    console.log("Creating notification for user", userId, title, message);
    
    // In a production app, we would insert this into a notifications table
    // For now, let's return a mock notification
    const mockNotification: Notification = {
      id: `notification-${Date.now()}`,
      user_id: userId,
      title,
      message,
      is_read: false,
      created_at: new Date().toISOString()
    };
    
    return mockNotification;
  } catch (error) {
    console.error('Error creating notification:', error);
    return null;
  }
}

// Create a notification for all staff members
async function createStaffNotification(
  title: string, 
  message: string
): Promise<Notification[]> {
  try {
    // Get all staff user IDs
    const { data: staffUsers, error: staffError } = await supabase
      .from('users')
      .select('id')
      .in('role', ['admin', 'manager', 'staff']);
      
    if (staffError || !staffUsers || staffUsers.length === 0) {
      console.error('No staff users found or error fetching staff:', staffError);
      return [];
    }
    
    // Create notifications for each staff member
    const notifications: Notification[] = [];
    for (const user of staffUsers) {
      const notification = await createUserNotification(user.id, title, message);
      if (notification) {
        notifications.push(notification);
      }
    }
    
    return notifications;
  } catch (error) {
    console.error('Error creating staff notifications:', error);
    return [];
  }
}

// Create a booking-related notification
export async function createBookingNotification(
  booking: Booking, 
  eventType: string
): Promise<void> {
  try {
    const bookingNumber = booking.booking_number;
    const guestName = booking.guest_name;
    let title = '';
    let message = '';
    
    // Generate notification content based on event type
    if (eventType === 'created') {
      title = 'New Booking Created';
      message = `Booking #${bookingNumber} for ${guestName} has been created.`;
    } else if (eventType === 'updated') {
      title = 'Booking Updated';
      message = `Booking #${bookingNumber} for ${guestName} has been updated.`;
    } else if (eventType === 'cancelled') {
      title = 'Booking Cancelled';
      message = `Booking #${bookingNumber} for ${guestName} has been cancelled.`;
    } else if (eventType === 'checked-in') {
      title = 'Guest Checked In';
      message = `${guestName} has checked in (Booking #${bookingNumber}).`;
    } else if (eventType === 'checked-out') {
      title = 'Guest Checked Out';
      message = `${guestName} has checked out (Booking #${bookingNumber}).`;
    }
    
    // Create notification for all staff
    await createStaffNotification(title, message);
    
  } catch (error) {
    console.error('Error creating booking notification:', error);
  }
}

// Create a notification for cleaning staff about a task
export async function createCleaningNotification(
  roomNumber: string, 
  taskId: string,
  assignedToId?: string
): Promise<void> {
  try {
    const title = 'New Cleaning Task';
    const message = `Room ${roomNumber} needs to be cleaned. Please check your tasks.`;
    
    if (assignedToId) {
      // Notify specific cleaning staff
      await createUserNotification(assignedToId, title, message);
    } else {
      // Notify all cleaning staff
      const { data: cleaners, error } = await supabase
        .from('users')
        .select('id')
        .eq('role', 'cleaner');
        
      if (!error && cleaners) {
        for (const cleaner of cleaners) {
          await createUserNotification(cleaner.id, title, message);
        }
      }
    }
  } catch (error) {
    console.error('Error creating cleaning notification:', error);
  }
}

// Send a notification to a specific room owner
export async function createOwnerNotification(
  ownerId: string,
  title: string,
  message: string
): Promise<void> {
  try {
    // Get the owner's email to find their user account
    const { data: owner, error: ownerError } = await supabase
      .from('owners')
      .select('email')
      .eq('id', ownerId)
      .single();
      
    if (ownerError || !owner) {
      console.error('Owner not found:', ownerError);
      return;
    }
    
    // Find the user with the matching email
    const { data: user, error: userError } = await supabase
      .from('users')
      .select('id')
      .eq('email', owner.email)
      .single();
      
    if (userError || !user) {
      console.error('No user account found for owner:', userError);
      return;
    }
    
    // Create notification for the owner's user account
    await createUserNotification(user.id, title, message);
    
  } catch (error) {
    console.error('Error creating owner notification:', error);
  }
}

// Create a notification about a maintenance issue
export async function createMaintenanceNotification(
  roomNumber: string,
  issue: string
): Promise<void> {
  try {
    const title = 'Maintenance Required';
    const message = `Room ${roomNumber} has an issue: ${issue}`;
    
    // Notify maintenance staff
    const { data: maintenance, error } = await supabase
      .from('users')
      .select('id')
      .eq('role', 'maintenance');
      
    if (!error && maintenance && maintenance.length > 0) {
      for (const staff of maintenance) {
        await createUserNotification(staff.id, title, message);
      }
    } else {
      // If no specific maintenance staff, notify all staff
      await createStaffNotification(title, message);
    }
  } catch (error) {
    console.error('Error creating maintenance notification:', error);
  }
}

// Mark all notifications as read for a user
export async function markAllNotificationsRead(userId: string): Promise<void> {
  try {
    console.log("Marking all notifications as read for user", userId);
    // In a production app, this would update the notifications table
    // For this demo, let's just log it
  } catch (error) {
    console.error('Error marking notifications as read:', error);
  }
}

// Get unread notification count for a user
export async function getUnreadNotificationCount(userId: string): Promise<number> {
  try {
    // In a production app, this would query the notifications table
    // For this demo, let's return a random number
    return Math.floor(Math.random() * 5);
  } catch (error) {
    console.error('Error counting unread notifications:', error);
    return 0;
  }
}
