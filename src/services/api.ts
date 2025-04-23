
import { supabase, handleError } from '../integrations/supabase';
import { 
  Room, 
  Booking, 
  User, 
  Owner, 
  Expense, 
  CleaningTask,
  PropertyOwnership,
  Notification,
  AuditLog
} from './supabase-types';

// Generic CRUD functions - use 'any' to avoid type mismatches with Supabase tables for now
export async function getAll<T>(table: string): Promise<T[]> {
  try {
    const { data, error } = await supabase
      .from(table as any)
      .select('*');
    
    if (error) throw error;
    return data as T[];
  } catch (error) {
    console.error(`Error fetching ${table}:`, error);
    throw new Error(handleError(error));
  }
}

export async function getById<T>(table: string, id: string): Promise<T | null> {
  try {
    const { data, error } = await supabase
      .from(table as any)
      .select('*')
      .eq('id', id)
      .single();
    
    if (error) throw error;
    return data as T;
  } catch (error) {
    console.error(`Error fetching ${table} with ID ${id}:`, error);
    throw new Error(handleError(error));
  }
}

/**
 * Create an item
 */
export async function create<T>(table: string, data: Record<string, any>): Promise<T> {
  try {
    // Add timestamps
    const insertData = {
      ...data,
      created_at: data.created_at || new Date().toISOString(),
      updated_at: data.updated_at || new Date().toISOString(),
    };
    
    const { data: result, error } = await supabase
      .from(table as any)
      .insert(insertData as any)
      .select()
      .single();
    
    if (error) throw error;
    return result as T;
  } catch (error) {
    console.error(`Error creating ${table}:`, error);
    throw new Error(handleError(error));
  }
}

/**
 * Update an item
 */
export async function update<T>(table: string, id: string, data: Record<string, any>): Promise<T> {
  try {
    // Add updated timestamp
    const updateData = {
      ...data,
      updated_at: new Date().toISOString(),
    };
    
    const { data: result, error } = await supabase
      .from(table as any)
      .update(updateData as any)
      .eq('id', id)
      .select()
      .single();
    
    if (error) throw error;
    return result as T;
  } catch (error) {
    console.error(`Error updating ${table} with ID ${id}:`, error);
    throw new Error(handleError(error));
  }
}

/**
 * Remove an item
 */
export async function remove(table: string, id: string): Promise<void> {
  try {
    const { error } = await supabase
      .from(table as any)
      .delete()
      .eq('id', id);
    
    if (error) throw error;
  } catch (error) {
    console.error(`Error removing ${table} with ID ${id}:`, error);
    throw new Error(handleError(error));
  }
}

/**
 * Query with filters
 */
export async function query<T>(table: string, options: {
  filters?: Record<string, any>,
  order?: { column: string, ascending: boolean },
  limit?: number,
  offset?: number
}): Promise<T[]> {
  try {
    let query = supabase.from(table as any).select('*');
    
    // Apply filters
    if (options.filters) {
      Object.entries(options.filters).forEach(([key, value]) => {
        query = query.eq(key, value);
      });
    }
    
    // Apply ordering
    if (options.order) {
      query = query.order(options.order.column, { 
        ascending: options.order.ascending 
      });
    }
    
    // Apply pagination
    if (options.limit) {
      query = query.limit(options.limit);
    }
    
    if (options.offset) {
      query = query.range(options.offset, options.offset + (options.limit || 10) - 1);
    }
    
    const { data, error } = await query;
    
    if (error) throw error;
    return data as T[];
  } catch (error) {
    console.error(`Error querying ${table}:`, error);
    throw new Error(handleError(error));
  }
}

/**
 * Create audit log entry
 */
export async function createAuditLog(
  userId: string | null, 
  action: string, 
  resourceType: string, 
  resourceId?: string, 
  details?: Record<string, any>
): Promise<AuditLog> {
  try {
    const auditData = {
      user_id: userId,
      action,
      resource_type: resourceType,
      resource_id: resourceId,
      details,
      created_at: new Date().toISOString()
    };
    
    const { data, error } = await supabase
      .from('audit_logs')
      .insert(auditData)
      .select()
      .single();
      
    if (error) throw error;
    return data as AuditLog;
  } catch (error) {
    console.error('Error creating audit log:', error);
    // Don't throw here, just log the error
    return {} as AuditLog;
  }
}

// Booking specific functions
export async function fetchBookings(): Promise<Booking[]> {
  try {
    const { data, error } = await supabase
      .from('bookings')
      .select('*, rooms(number, property:type)')
      .order('check_in', { ascending: true });
      
    if (error) throw error;
    return data as unknown as Booking[];
  } catch (error) {
    console.error('Error fetching bookings:', error);
    throw new Error(handleError(error));
  }
}

export async function fetchBookingById(id: string): Promise<Booking> {
  try {
    const { data, error } = await supabase
      .from('bookings')
      .select('*, rooms(*, properties(name))')
      .eq('id', id)
      .single();
      
    if (error) throw error;
    return data as unknown as Booking;
  } catch (error) {
    console.error(`Error fetching booking with ID ${id}:`, error);
    throw new Error(handleError(error));
  }
}

export async function fetchTodayCheckins(): Promise<Booking[]> {
  const today = new Date().toISOString().split('T')[0];
  
  try {
    const { data, error } = await supabase
      .from('bookings')
      .select('*, rooms(number, property:type)')
      .eq('check_in', today)
      .eq('status', 'confirmed');
      
    if (error) throw error;
    return data as unknown as Booking[];
  } catch (error) {
    console.error('Error fetching today\'s check-ins:', error);
    throw new Error(handleError(error));
  }
}

export async function fetchTodayCheckouts(): Promise<Booking[]> {
  const today = new Date().toISOString().split('T')[0];
  
  try {
    const { data, error } = await supabase
      .from('bookings')
      .select('*, rooms(number, property:type)')
      .eq('check_out', today)
      .eq('status', 'checked-in');
      
    if (error) throw error;
    return data as unknown as Booking[];
  } catch (error) {
    console.error('Error fetching today\'s check-outs:', error);
    throw new Error(handleError(error));
  }
}

export async function updateBookingStatus(bookingId: string, status: string): Promise<Booking> {
  return update<Booking>('bookings', bookingId, { status });
}

export async function updateRoomStatus(roomId: string, status: string): Promise<Room> {
  return update<Room>('rooms', roomId, { status });
}

// Room specific functions
export async function fetchRooms(): Promise<Room[]> {
  try {
    const { data, error } = await supabase
      .from('rooms')
      .select('*, room_types(name, base_rate), properties(name)')
      .order('number', { ascending: true });
      
    if (error) throw error;
    return data as unknown as Room[];
  } catch (error) {
    console.error('Error fetching rooms:', error);
    throw new Error(handleError(error));
  }
}

export async function fetchRoomById(id: string): Promise<Room> {
  try {
    const { data, error } = await supabase
      .from('rooms')
      .select('*, room_types(name, base_rate), properties(name)')
      .eq('id', id)
      .single();
      
    if (error) throw error;
    return data as unknown as Room;
  } catch (error) {
    console.error(`Error fetching room with ID ${id}:`, error);
    throw new Error(handleError(error));
  }
}

// Cleaning tasks specific functions
export async function fetchCleaningTasks(): Promise<CleaningTask[]> {
  try {
    const { data, error } = await supabase
      .from('cleaning_tasks')
      .select('*, rooms(number, floor, type, property:type), users(name)')
      .order('date', { ascending: false });
      
    if (error) throw error;
    return data as unknown as CleaningTask[];
  } catch (error) {
    console.error('Error fetching cleaning tasks:', error);
    throw new Error(handleError(error));
  }
}

export async function updateCleaningTaskStatus(taskId: string, status: string): Promise<CleaningTask> {
  return update<CleaningTask>('cleaning_tasks', taskId, { status });
}

// Owner specific functions
export async function fetchOwners(): Promise<Owner[]> {
  try {
    const { data, error } = await supabase
      .from('owners')
      .select('*')
      .order('name', { ascending: true });
      
    if (error) throw error;
    return data as Owner[];
  } catch (error) {
    console.error('Error fetching owners:', error);
    throw new Error(handleError(error));
  }
}

export async function fetchPropertyOwnership(): Promise<PropertyOwnership[]> {
  try {
    const { data, error } = await supabase
      .from('property_ownership')
      .select('*, owners(name, email), rooms(number, type, property:type)');
      
    if (error) throw error;
    return data as unknown as PropertyOwnership[];
  } catch (error) {
    console.error('Error fetching property ownerships:', error);
    throw new Error(handleError(error));
  }
}
