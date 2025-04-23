
// Re-export the supabase client from client.ts where the URL and key are hardcoded
export { supabase } from './client';

// Error handling helper
export function handleError(error: any): string {
  // Supabase error format
  if (error?.message) {
    return error.message;
  }
  // Generic error
  return 'An unknown error occurred';
}
