
import { useQuery } from '@tanstack/react-query';
import { fetchUsers } from '@/services/api';

export const useUsers = () => {
  return useQuery({
    queryKey: ['users'],
    queryFn: fetchUsers
  });
};
