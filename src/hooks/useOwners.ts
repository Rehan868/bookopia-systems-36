
import { useQuery } from "@tanstack/react-query";
import { supabase } from "@/integrations/supabase/client";
import { Owner } from "../services/supabase-types";
import { mapOwnerFromDb } from "../services/data-mapper";

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
      return (ownersData || []).map(owner => mapOwnerFromDb(owner));
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
      
      return mapOwnerFromDb(owner);
    },
    enabled: !!id,
    staleTime: 1000 * 60 * 5, // 5 minutes
  });
};
