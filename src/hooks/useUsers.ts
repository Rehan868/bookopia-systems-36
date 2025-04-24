
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { supabase } from "@/integrations/supabase/client";
import { useToast } from "./use-toast";

export type User = {
  id: string;
  name: string;
  email: string;
  role: string;
  avatar?: string;
  lastActive?: string; // Add this property to fix the error in UserView
};

export const useUsers = () => {
  return useQuery({
    queryKey: ["users"],
    queryFn: async (): Promise<User[]> => {
      const { data, error } = await supabase
        .from('users')
        .select('id, name, email, role, avatar, last_active')
        .order('name');
      
      if (error) {
        console.error('Error fetching users:', error);
        throw error;
      }
      
      return data.map((user: any) => ({
        ...user,
        id: user.id.toString(),
        lastActive: user.last_active // Map from snake_case to camelCase
      })) as User[];
    },
    staleTime: 1000 * 60 * 5, // 5 minutes
  });
};

export const useUser = (id: string) => {
  return useQuery({
    queryKey: ["user", id],
    queryFn: async (): Promise<User> => {
      if (!id) throw new Error('User ID is required');
      
      const { data, error } = await supabase
        .from('users')
        .select('id, name, email, role, avatar')
        .eq('id', parseInt(id))
        .single();
      
      if (error) {
        console.error(`Error fetching user with ID ${id}:`, error);
        throw error;
      }
      
      if (!data) {
        throw new Error(`User with ID ${id} not found`);
      }
      
      return {
        ...data,
        id: data.id.toString()
      } as User;
    },
    enabled: !!id,
    staleTime: 1000 * 60 * 5, // 5 minutes
  });
};

export const useDeleteUser = () => {
  const queryClient = useQueryClient();
  const { toast } = useToast();
  
  return useMutation({
    mutationFn: async (userId: string) => {
      // First delete the user's auth account
      const { error: authError } = await supabase.auth.admin.deleteUser(userId);
      
      if (authError) {
        throw authError;
      }
      
      // Then delete the user's profile
      const { error } = await supabase
        .from('users')
        .delete()
        .eq('id', parseInt(userId));
        
      if (error) {
        throw error;
      }
      
      return userId;
    },
    onSuccess: (userId) => {
      queryClient.invalidateQueries({ queryKey: ['users'] });
      toast({
        title: 'User Deleted',
        description: 'The user has been removed successfully',
      });
    },
    onError: (error: any) => {
      toast({
        title: 'Error',
        description: error.message || 'Failed to delete user',
        variant: 'destructive',
      });
    }
  });
};

export const useUserRoles = () => {
  return useQuery({
    queryKey: ["user-roles"],
    queryFn: async () => {
      const { data, error } = await supabase
        .from('user_roles')
        .select('*')
        .order('name');
      
      if (error) {
        console.error('Error fetching user roles:', error);
        throw error;
      }
      
      return data || [];
    },
    staleTime: 1000 * 60 * 5, // 5 minutes
  });
};
