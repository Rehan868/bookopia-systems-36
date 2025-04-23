import { supabase, handleError } from '../integrations/supabase';
import { 
  Room, 
  Booking, 
  User, 
  Owner, 
  Expense, 
  CleaningTask,
  PropertyOwnership
} from './supabase-types';

// Generic CRUD functions
export async function getAll<T>(table: string): Promise<T[]> {
  try {
    const { data, error } = await supabase
      .from(table)
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
      .from(table)
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
      .from(table)
      .insert(insertData)
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
      .from(table)
      .update(updateData)
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
 * Delete an item
 */
export async function remove(table: string, id: string): Promise<void> {
  try {
    const { error } = await supabase
      .from(table)
      .delete()
      .eq('id', id);
    
    if (error) throw error;
  } catch (error) {
    console.error(`Error deleting ${table} with ID ${id}:`, error);
    throw new Error(handleError(error));
  }
}

/**
 * Generic fetch function to get data from supabase with advanced options
 */
export async function fetchList<T>(
  table: string, 
  options: {
    select?: string;
    filters?: Record<string, any>;
    eq?: Record<string, any>;
    order?: { column: string; ascending?: boolean };
    range?: { from: number; to: number };
    limit?: number;
  } = {}
): Promise<T[]> {
  try {
    let query = supabase
      .from(table)
      .select(options.select || '*');
    
    // Apply filters
    if (options.filters) {
      Object.entries(options.filters).forEach(([key, value]) => {
        if (value !== undefined && value !== null) {
          query = query.filter(key, 'eq', value);
        }
      });
    }
    
    // Apply equality filters
    if (options.eq) {
      Object.entries(options.eq).forEach(([key, value]) => {
        if (value !== undefined && value !== null) {
          query = query.eq(key, value);
        }
      });
    }
    
    // Apply ordering
    if (options.order) {
      query = query.order(options.order.column, { 
        ascending: options.order.ascending !== false
      });
    }
    
    // Apply pagination
    if (options.range) {
      query = query.range(options.range.from, options.range.to);
    }
    
    // Apply limit
    if (options.limit) {
      query = query.limit(options.limit);
    }
    
    const { data, error } = await query;
    
    if (error) {
      throw error;
    }
    
    return data as T[];
  } catch (error) {
    console.error(`Error fetching ${table}:`, error);
    throw new Error(handleError(error));
  }
}

/**
 * Fetch a single item by id with options
 */
export async function fetchById<T>(
  table: string,
  id: string,
  options: {
    select?: string;
  } = {}
): Promise<T | null> {
  try {
    const { data, error } = await supabase
      .from(table)
      .select(options.select || '*')
      .eq('id', id)
      .single();
    
    if (error) {
      if (error.code === 'PGRST116') {
        // PGRST116 is "no rows returned" error
        return null;
      }
      throw error;
    }
    
    return data as T;
  } catch (error) {
    console.error(`Error fetching ${table} with id ${id}:`, error);
    throw new Error(handleError(error));
  }
}

// Custom query function with more advanced options
export async function query<T>(table: string, options: {
  select?: string,
  filters?: Record<string, any>,
  order?: { column: string, ascending?: boolean },
  limit?: number,
  range?: { from: number, to: number }
}): Promise<T[]> {
  try {
    let query = supabase
      .from(table)
      .select(options.select || '*');
    
    // Apply filters
    if (options.filters) {
      Object.entries(options.filters).forEach(([key, value]) => {
        // Handle different types of filters
        if (Array.isArray(value)) {
          query = query.in(key, value);
        } else if (typeof value === 'object' && value !== null) {
          // Handle range filters with gt, lt, etc.
          Object.entries(value).forEach(([op, val]) => {
            switch(op) {
              case 'gt': query = query.gt(key, val); break;
              case 'lt': query = query.lt(key, val); break;
              case 'gte': query = query.gte(key, val); break;
              case 'lte': query = query.lte(key, val); break;
              case 'neq': query = query.neq(key, val); break;
              default: query = query.eq(key, val);
            }
          });
        } else {
          query = query.eq(key, value);
        }
      });
    }
    
    // Apply ordering
    if (options.order) {
      query = query.order(options.order.column, {
        ascending: options.order.ascending ?? true
      });
    }
    
    // Apply limit
    if (options.limit) {
      query = query.limit(options.limit);
    }
    
    // Apply range
    if (options.range) {
      query = query.range(options.range.from, options.range.to);
    }
    
    const { data, error } = await query;
    
    if (error) throw error;
    return data as T[];
  } catch (error) {
    console.error(`Error querying ${table}:`, error);
    throw new Error(handleError(error));
  }
}

// Function to create an audit log
export async function createAuditLog(
  userId: string | null, 
  action: string, 
  resourceType: string | null, 
  resourceId: string | null,
  details: any = {}
): Promise<void> {
  try {
    const { error } = await supabase
      .from('audit_logs')
      .insert({
        user_id: userId,
        action,
        resource_type: resourceType,
        resource_id: resourceId,
        details,
        created_at: new Date().toISOString()
      });
    
    if (error) {
      console.error(`Error creating audit log:`, error);
      // Don't throw the error since audit logs are not critical
    }
  } catch (error) {
    console.error(`Error creating audit log:`, error);
    // Don't throw the error since audit logs are not critical
  }
}

// Specific data fetching functions
export const fetchRooms = async (filters?: Record<string, any>): Promise<Room[]> => {
  return fetchList<Room>('rooms', {
    select: '*, properties(name), room_types(name, base_rate)',
    filters,
    order: { column: 'number' }
  });
};

export const fetchRoomById = async (id: string): Promise<Room> => {
  const result = await fetchById<Room>('rooms', id, {
    select: '*, properties(name), room_types(name, base_rate)'
  });
  if (!result) throw new Error(`Room with ID ${id} not found`);
  return result;
};

export const fetchRoomByNumber = async (number: string): Promise<Room | null> => {
  try {
    const { data, error } = await supabase
      .from('rooms')
      .select('*, properties(name), room_types(name, base_rate)')
      .eq('number', number)
      .single();
    
    if (error) {
      if (error.code === 'PGRST116') return null;
      throw error;
    }
    
    return data as Room;
  } catch (error) {
    console.error(`Error fetching room with number ${number}:`, error);
    throw new Error(handleError(error));
  }
};

export const fetchBookings = async (filters?: Record<string, any>): Promise<Booking[]> => {
  return fetchList<Booking>('bookings', {
    select: '*, rooms(number, property_id, properties:property_id(name))',
    filters,
    order: { column: 'check_in' }
  });
};

export const fetchBookingById = async (id: string): Promise<Booking> => {
  const result = await fetchById<Booking>('bookings', id, {
    select: '*, rooms(number, property_id, properties:property_id(name))'
  });
  if (!result) throw new Error(`Booking with ID ${id} not found`);
  return result;
};

export const fetchTodayCheckins = async (): Promise<Booking[]> => {
  const today = new Date().toISOString().split('T')[0];
  return fetchList<Booking>('bookings', {
    select: '*, rooms(number, property_id, properties:property_id(name))',
    eq: { check_in: today, status: 'confirmed' }
  });
};

export const fetchTodayCheckouts = async (): Promise<Booking[]> => {
  const today = new Date().toISOString().split('T')[0];
  return fetchList<Booking>('bookings', {
    select: '*, rooms(number, property_id, properties:property_id(name))',
    eq: { check_out: today, status: 'checked-in' }
  });
};

export const fetchUsers = async (): Promise<User[]> => {
  return fetchList<User>('users');
};

export const fetchOwners = async (): Promise<Owner[]> => {
  return fetchList<Owner>('owners');
};

export const fetchExpenses = async (): Promise<Expense[]> => {
  return fetchList<Expense>('expenses', {
    order: { column: 'date', ascending: false }
  });
};

export const fetchCleaningTasks = async (): Promise<CleaningTask[]> => {
  return fetchList<CleaningTask>('cleaning_tasks', {
    select: '*, rooms(number, property_id, properties:property_id(name)), users(name)'
  });
};

export const fetchPropertyOwnership = async (): Promise<PropertyOwnership[]> => {
  return fetchList<PropertyOwnership>('property_ownership', {
    select: '*, rooms(number), owners(name)'
  });
};

export const updateBookingStatus = async (
  bookingId: string, 
  status: string
): Promise<void> => {
  try {
    const { error } = await supabase
      .from('bookings')
      .update({ 
        status,
        updated_at: new Date().toISOString()
      })
      .eq('id', bookingId);
    
    if (error) throw error;
  } catch (error) {
    console.error(`Error updating booking status:`, error);
    throw new Error(handleError(error));
  }
};

export const updateRoomStatus = async (
  roomId: string, 
  status: string
): Promise<void> => {
  try {
    const { error } = await supabase
      .from('rooms')
      .update({ 
        status,
        updated_at: new Date().toISOString()
      })
      .eq('id', roomId);
    
    if (error) throw error;
  } catch (error) {
    console.error(`Error updating room status:`, error);
    throw new Error(handleError(error));
  }
};

export const updateCleaningTaskStatus = async (
  taskId: string, 
  status: string
): Promise<void> => {
  try {
    const { error } = await supabase
      .from('cleaning_tasks')
      .update({ 
        status,
        updated_at: new Date().toISOString()
      })
      .eq('id', taskId);
    
    if (error) throw error;
  } catch (error) {
    console.error(`Error updating cleaning task status:`, error);
    throw new Error(handleError(error));
  }
};
