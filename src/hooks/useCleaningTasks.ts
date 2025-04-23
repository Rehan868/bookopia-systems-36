
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { useToast } from './use-toast';
import { supabase } from "@/integrations/supabase/client";

// Define types
export interface CleaningTask {
  id: string;
  room_id: string;
  room: {
    number: string;
    property: string;
  };
  status: string;
  scheduled_date: string;
  assigned_to: string | null;
  notes: string | null;
  created_at: string;
  completed_at: string | null;
}

// Fetch cleaning tasks from cleaning_statuses table
export const fetchCleaningTasks = async (): Promise<CleaningTask[]> => {
  const { data, error } = await supabase
    .from('cleaning_statuses')
    .select(`
      id,
      room_id,
      status,
      cleaned_at,
      cleaned_by,
      notes,
      created_at,
      rooms:room_id (
        room_number,
        property_id
      )
    `);

  if (error) {
    console.error('Error fetching cleaning tasks:', error);
    throw error;
  }

  // Transform data to match our CleaningTask interface
  return (data || []).map(task => ({
    id: task.id.toString(),
    room_id: task.room_id?.toString() || '',
    room: {
      number: task.rooms?.room_number || 'Unknown',
      property: task.rooms?.property_id?.toString() || 'Unknown'
    },
    status: task.status || 'pending',
    scheduled_date: task.created_at,
    assigned_to: task.cleaned_by?.toString() || null,
    notes: task.notes,
    created_at: task.created_at,
    completed_at: task.cleaned_at
  }));
};

// Update cleaning task status
export const updateCleaningTaskStatus = async (id: string, status: string): Promise<void> => {
  const { error } = await supabase
    .from('cleaning_statuses')
    .update({ status })
    .eq('id', id);

  if (error) {
    console.error(`Error updating cleaning task status for ID ${id}:`, error);
    throw error;
  }
};

export const useCleaningTasks = () => {
  return useQuery({
    queryKey: ['cleaning-tasks'],
    queryFn: fetchCleaningTasks
  });
};

export const useUpdateCleaningTaskStatus = () => {
  const queryClient = useQueryClient();
  const { toast } = useToast();
  
  return useMutation({
    mutationFn: ({ id, status }: { id: string, status: string }) => {
      return updateCleaningTaskStatus(id, status);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['cleaning-tasks'] });
      toast({
        title: 'Cleaning task updated',
        description: 'The cleaning task status has been updated successfully',
      });
    },
    onError: (error) => {
      toast({
        title: 'Failed to update cleaning task',
        description: error instanceof Error ? error.message : 'An unknown error occurred',
        variant: 'destructive',
      });
    }
  });
};
