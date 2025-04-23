
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
