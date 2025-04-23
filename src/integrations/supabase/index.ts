import { createClient } from '@supabase/supabase-js';
import { Database } from './database.types';

// Get environment variables for Supabase connection
const supabaseUrl = import.meta.env.VITE_SUPABASE_URL || '';
const supabaseKey = import.meta.env.VITE_SUPABASE_ANON_KEY || '';

// Initialize Supabase client
export const supabase = createClient<Database>(supabaseUrl, supabaseKey);

// Error handling helper
export function handleError(error: any): string {
  // Supabase error format
  if (error?.message) {
    return error.message;
  }
  // Generic error
  return 'An unknown error occurred';
}