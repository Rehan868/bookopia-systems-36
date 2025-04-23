
import { useQuery } from "@tanstack/react-query";
import { supabase } from "@/integrations/supabase/client";

export interface Owner {
  id: string;
  first_name: string;
  last_name: string;
  email: string;
  phone: string | null;
  properties: number; // Number of properties owned
  revenue: number;
  occupancy: number;
  avatar?: string;
  paymentDetails: {
    bank: string;
    accountNumber: string;
    routingNumber: string;
  };
  joinedDate: string;
}

export const useOwners = () => {
  return useQuery({
    queryKey: ["owners"],
    queryFn: async () => {
      // Fetch owners from Supabase
      const { data: ownersData, error } = await supabase
        .from('owners')
        .select('*');
      
      if (error) throw error;
      
      // Transform the data to match our Owner interface
      return (ownersData || []).map(owner => ({
        id: owner.id.toString(),
        first_name: owner.first_name,
        last_name: owner.last_name,
        name: `${owner.first_name} ${owner.last_name}`,
        email: owner.email || '',
        phone: owner.phone,
        // These would come from calculations in a real app
        properties: 2, // Mock number of properties
        revenue: 25000, // Mock revenue
        occupancy: 75, // Mock occupancy percentage
        avatar: null, // Mock avatar
        paymentDetails: {
          bank: owner.payment_details?.bank || '',
          accountNumber: owner.payment_details?.account_number || '',
          routingNumber: owner.payment_details?.routing_number || ''
        },
        joinedDate: owner.created_at?.split('T')[0] || ''
      })) as Owner[];
    },
    staleTime: 1000 * 60 * 5, // 5 minutes
  });
};

export const useOwner = (id: string) => {
  return useQuery({
    queryKey: ["owner", id],
    queryFn: async () => {
      if (!id) throw new Error("Owner ID is required");
      
      const { data: owner, error } = await supabase
        .from('owners')
        .select('*')
        .eq('id', id)
        .single();
      
      if (error) throw error;
      if (!owner) throw new Error(`Owner with ID ${id} not found`);
      
      // Transform the data to match our Owner interface
      return {
        id: owner.id.toString(),
        first_name: owner.first_name,
        last_name: owner.last_name,
        name: `${owner.first_name} ${owner.last_name}`,
        email: owner.email || '',
        phone: owner.phone,
        // These would come from calculations in a real app
        properties: 2, // Mock number of properties
        revenue: 25000, // Mock revenue
        occupancy: 75, // Mock occupancy percentage
        avatar: null, // Mock avatar
        paymentDetails: {
          bank: owner.payment_details?.bank || '',
          accountNumber: owner.payment_details?.account_number || '',
          routingNumber: owner.payment_details?.routing_number || ''
        },
        joinedDate: owner.created_at?.split('T')[0] || ''
      } as Owner;
    },
    enabled: !!id,
    staleTime: 1000 * 60 * 5, // 5 minutes
  });
};
