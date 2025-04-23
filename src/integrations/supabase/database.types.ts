export type Json =
  | string
  | number
  | boolean
  | null
  | { [key: string]: Json | undefined }
  | Json[];

export interface Database {
  public: {
    Tables: {
      audit_logs: {
        Row: {
          id: string
          user_id: string | null
          action: string
          resource_type: string | null
          resource_id: string | null
          details: Json | null
          created_at: string | null
        }
        Insert: {
          id?: string
          user_id?: string | null
          action: string
          resource_type?: string | null
          resource_id?: string | null
          details?: Json | null
          created_at?: string | null
        }
        Update: {
          id?: string
          user_id?: string | null
          action?: string
          resource_type?: string | null
          resource_id?: string | null
          details?: Json | null
          created_at?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "audit_logs_user_id_fkey"
            columns: ["user_id"]
            isOneToOne: false
            referencedRelation: "users"
            referencedColumns: ["id"]
          }
        ]
      }
      bookings: {
        Row: {
          id: string
          property_id: string | null
          room_id: string | null
          guest_id: string | null
          booking_number: string
          guest_name: string
          check_in: string
          check_out: string
          adults: number
          children: number
          amount: number
          payment_status: string | null
          status: string
          special_requests: string | null
          created_by: string | null
          created_at: string | null
          updated_at: string | null
          amount_paid: number | null
          remaining_amount: number | null
          guest_email: string | null
          guest_phone: string | null
          commission: number | null
          vat: number | null
          tourism_fee: number | null
          net_to_owner: number | null
          security_deposit: number | null
        }
        Insert: {
          id?: string
          property_id?: string | null
          room_id?: string | null
          guest_id?: string | null
          booking_number: string
          guest_name: string
          check_in: string
          check_out: string
          adults: number
          children: number
          amount: number
          payment_status?: string | null
          status: string
          special_requests?: string | null
          created_by?: string | null
          created_at?: string | null
          updated_at?: string | null
          amount_paid?: number | null
          remaining_amount?: number | null
          guest_email?: string | null
          guest_phone?: string | null
          commission?: number | null
          vat?: number | null
          tourism_fee?: number | null
          net_to_owner?: number | null
          security_deposit?: number | null
        }
        Update: {
          id?: string
          property_id?: string | null
          room_id?: string | null
          guest_id?: string | null
          booking_number?: string
          guest_name?: string
          check_in?: string
          check_out?: string
          adults?: number
          children?: number
          amount?: number
          payment_status?: string | null
          status?: string
          special_requests?: string | null
          created_by?: string | null
          created_at?: string | null
          updated_at?: string | null
          amount_paid?: number | null
          remaining_amount?: number | null
          guest_email?: string | null
          guest_phone?: string | null
          commission?: number | null
          vat?: number | null
          tourism_fee?: number | null
          net_to_owner?: number | null
          security_deposit?: number | null
        }
        Relationships: [
          {
            foreignKeyName: "bookings_guest_id_fkey"
            columns: ["guest_id"]
            isOneToOne: false
            referencedRelation: "guests"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "bookings_property_id_fkey"
            columns: ["property_id"]
            isOneToOne: false
            referencedRelation: "properties"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "bookings_room_id_fkey"
            columns: ["room_id"]
            isOneToOne: false
            referencedRelation: "rooms"
            referencedColumns: ["id"]
          }
        ]
      }
      cleaning_tasks: {
        Row: {
          id: string
          property_id: string | null
          room_id: string
          assigned_to: string | null
          date: string
          status: string
          notes: string | null
          created_at: string | null
          updated_at: string | null
        }
        Insert: {
          id?: string
          property_id?: string | null
          room_id: string
          assigned_to?: string | null
          date: string
          status: string
          notes?: string | null
          created_at?: string | null
          updated_at?: string | null
        }
        Update: {
          id?: string
          property_id?: string | null
          room_id?: string
          assigned_to?: string | null
          date?: string
          status?: string
          notes?: string | null
          created_at?: string | null
          updated_at?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "cleaning_tasks_assigned_to_fkey"
            columns: ["assigned_to"]
            isOneToOne: false
            referencedRelation: "users"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "cleaning_tasks_property_id_fkey"
            columns: ["property_id"]
            isOneToOne: false
            referencedRelation: "properties"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "cleaning_tasks_room_id_fkey"
            columns: ["room_id"]
            isOneToOne: false
            referencedRelation: "rooms"
            referencedColumns: ["id"]
          }
        ]
      }
      expenses: {
        Row: {
          id: string
          property_id: string | null
          category: string
          description: string
          amount: number
          date: string
          payment_method: string
          status: string
          created_by: string | null
          created_at: string | null
          updated_at: string | null
        }
        Insert: {
          id?: string
          property_id?: string | null
          category: string
          description: string
          amount: number
          date: string
          payment_method: string
          status: string
          created_by?: string | null
          created_at?: string | null
          updated_at?: string | null
        }
        Update: {
          id?: string
          property_id?: string | null
          category?: string
          description?: string
          amount?: number
          date?: string
          payment_method?: string
          status?: string
          created_by?: string | null
          created_at?: string | null
          updated_at?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "expenses_created_by_fkey"
            columns: ["created_by"]
            isOneToOne: false
            referencedRelation: "users"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "expenses_property_id_fkey"
            columns: ["property_id"]
            isOneToOne: false
            referencedRelation: "properties"
            referencedColumns: ["id"]
          }
        ]
      }
      guests: {
        Row: {
          id: string
          first_name: string
          last_name: string
          email: string | null
          phone: string | null
          address: string | null
          city: string | null
          state: string | null
          country: string | null
          postal_code: string | null
          id_type: string | null
          id_number: string | null
          notes: string | null
          created_at: string | null
          updated_at: string | null
        }
        Insert: {
          id?: string
          first_name: string
          last_name: string
          email?: string | null
          phone?: string | null
          address?: string | null
          city?: string | null
          state?: string | null
          country?: string | null
          postal_code?: string | null
          id_type?: string | null
          id_number?: string | null
          notes?: string | null
          created_at?: string | null
          updated_at?: string | null
        }
        Update: {
          id?: string
          first_name?: string
          last_name?: string
          email?: string | null
          phone?: string | null
          address?: string | null
          city?: string | null
          state?: string | null
          country?: string | null
          postal_code?: string | null
          id_type?: string | null
          id_number?: string | null
          notes?: string | null
          created_at?: string | null
          updated_at?: string | null
        }
        Relationships: []
      }
      notifications: {
        Row: {
          id: string
          user_id: string | null
          title: string
          message: string
          is_read: boolean | null
          created_at: string | null
        }
        Insert: {
          id?: string
          user_id?: string | null
          title: string
          message: string
          is_read?: boolean | null
          created_at?: string | null
        }
        Update: {
          id?: string
          user_id?: string | null
          title?: string
          message?: string
          is_read?: boolean | null
          created_at?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "notifications_user_id_fkey"
            columns: ["user_id"]
            isOneToOne: false
            referencedRelation: "users"
            referencedColumns: ["id"]
          }
        ]
      }
      owners: {
        Row: {
          id: string
          name: string
          email: string
          phone: string | null
          payment_info: Json | null
          created_at: string | null
          updated_at: string | null
        }
        Insert: {
          id?: string
          name: string
          email: string
          phone?: string | null
          payment_info?: Json | null
          created_at?: string | null
          updated_at?: string | null
        }
        Update: {
          id?: string
          name?: string
          email?: string
          phone?: string | null
          payment_info?: Json | null
          created_at?: string | null
          updated_at?: string | null
        }
        Relationships: []
      }
      properties: {
        Row: {
          id: string
          name: string
          address: string
          city: string
          state: string | null
          country: string
          postal_code: string | null
          phone: string | null
          email: string | null
          website: string | null
          tax_rate: number | null
          timezone: string | null
          check_in_time: string | null
          check_out_time: string | null
          created_at: string | null
          updated_at: string | null
        }
        Insert: {
          id?: string
          name: string
          address: string
          city: string
          state?: string | null
          country: string
          postal_code?: string | null
          phone?: string | null
          email?: string | null
          website?: string | null
          tax_rate?: number | null
          timezone?: string | null
          check_in_time?: string | null
          check_out_time?: string | null
          created_at?: string | null
          updated_at?: string | null
        }
        Update: {
          id?: string
          name?: string
          address?: string
          city?: string
          state?: string | null
          country?: string
          postal_code?: string | null
          phone?: string | null
          email?: string | null
          website?: string | null
          tax_rate?: number | null
          timezone?: string | null
          check_in_time?: string | null
          check_out_time?: string | null
          created_at?: string | null
          updated_at?: string | null
        }
        Relationships: []
      }
      property_ownership: {
        Row: {
          id: string
          owner_id: string | null
          room_id: string | null
          commission_rate: number
          contract_start_date: string
          contract_end_date: string | null
          created_at: string | null
          updated_at: string | null
        }
        Insert: {
          id?: string
          owner_id?: string | null
          room_id?: string | null
          commission_rate: number
          contract_start_date: string
          contract_end_date?: string | null
          created_at?: string | null
          updated_at?: string | null
        }
        Update: {
          id?: string
          owner_id?: string | null
          room_id?: string | null
          commission_rate?: number
          contract_start_date?: string
          contract_end_date?: string | null
          created_at?: string | null
          updated_at?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "property_ownership_owner_id_fkey"
            columns: ["owner_id"]
            isOneToOne: false
            referencedRelation: "owners"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "property_ownership_room_id_fkey"
            columns: ["room_id"]
            isOneToOne: false
            referencedRelation: "rooms"
            referencedColumns: ["id"]
          }
        ]
      }
      room_types: {
        Row: {
          id: string
          property_id: string | null
          name: string
          description: string | null
          base_rate: number
          max_occupancy: number
          created_at: string | null
          updated_at: string | null
        }
        Insert: {
          id?: string
          property_id?: string | null
          name: string
          description?: string | null
          base_rate: number
          max_occupancy: number
          created_at?: string | null
          updated_at?: string | null
        }
        Update: {
          id?: string
          property_id?: string | null
          name?: string
          description?: string | null
          base_rate?: number
          max_occupancy?: number
          created_at?: string | null
          updated_at?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "room_types_property_id_fkey"
            columns: ["property_id"]
            isOneToOne: false
            referencedRelation: "properties"
            referencedColumns: ["id"]
          }
        ]
      }
      rooms: {
        Row: {
          id: string
          property_id: string | null
          room_type_id: string | null
          number: string
          floor: string
          type: string
          description: string | null
          capacity: number
          rate: number
          status: string
          amenities: string[] | null
          features: Json | null
          created_at: string | null
          updated_at: string | null
        }
        Insert: {
          id?: string
          property_id?: string | null
          room_type_id?: string | null
          number: string
          floor: string
          type: string
          description?: string | null
          capacity: number
          rate: number
          status: string
          amenities?: string[] | null
          features?: Json | null
          created_at?: string | null
          updated_at?: string | null
        }
        Update: {
          id?: string
          property_id?: string | null
          room_type_id?: string | null
          number?: string
          floor?: string
          type?: string
          description?: string | null
          capacity?: number
          rate?: number
          status?: string
          amenities?: string[] | null
          features?: Json | null
          created_at?: string | null
          updated_at?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "rooms_property_id_fkey"
            columns: ["property_id"]
            isOneToOne: false
            referencedRelation: "properties"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "rooms_room_type_id_fkey"
            columns: ["room_type_id"]
            isOneToOne: false
            referencedRelation: "room_types"
            referencedColumns: ["id"]
          }
        ]
      }
      users: {
        Row: {
          id: string
          email: string
          name: string
          role: string
          status: string
          avatar_url: string | null
          last_active: string | null
          created_at: string | null
          updated_at: string | null
        }
        Insert: {
          id?: string
          email: string
          name: string
          role: string
          status: string
          avatar_url?: string | null
          last_active?: string | null
          created_at?: string | null
          updated_at?: string | null
        }
        Update: {
          id?: string
          email?: string
          name?: string
          role?: string
          status?: string
          avatar_url?: string | null
          last_active?: string | null
          created_at?: string | null
          updated_at?: string | null
        }
        Relationships: []
      }
    };
    Views: {
      [_ in never]: never;
    };
    Functions: {
      [_ in never]: never;
    };
    Enums: {
      [_ in never]: never;
    };
    CompositeTypes: {
      [_ in never]: never;
    };
  };
}