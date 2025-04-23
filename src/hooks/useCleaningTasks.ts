
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { useToast } from './use-toast';
import { supabase } from "@/integrations/supabase/client";
import { CleaningTask } from '../services/supabase-types';
import { fetchCleaningTasks } from '../services/api';

// Update cleaning task status
export const updateCleaningTaskStatus = async (id: number, status: string): Promise<void> => {
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
    mutationFn: ({ id, status }: { id: number, status: string }) => {
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
