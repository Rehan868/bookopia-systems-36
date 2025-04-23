export type Json =
  | string
  | number
  | boolean
  | null
  | { [key: string]: Json | undefined }
  | Json[]

export type Database = {
  public: {
    Tables: {
      audit_logs: {
        Row: {
          action: string
          created_at: string | null
          details: Json | null
          entity_id: number | null
          entity_type: string
          id: number
          ip_address: string | null
          user_agent: string | null
          user_id: number | null
        }
        Insert: {
          action: string
          created_at?: string | null
          details?: Json | null
          entity_id?: number | null
          entity_type: string
          id?: number
          ip_address?: string | null
          user_agent?: string | null
          user_id?: number | null
        }
        Update: {
          action?: string
          created_at?: string | null
          details?: Json | null
          entity_id?: number | null
          entity_type?: string
          id?: number
          ip_address?: string | null
          user_agent?: string | null
          user_id?: number | null
        }
        Relationships: [
          {
            foreignKeyName: "audit_logs_user_id_fkey"
            columns: ["user_id"]
            isOneToOne: false
            referencedRelation: "users"
            referencedColumns: ["id"]
          },
        ]
      }
      bookings: {
        Row: {
          adults: number | null
          check_in_date: string
          check_out_date: string
          children: number | null
          confirmation_code: string | null
          created_at: string | null
          created_by: number | null
          guest_id: number | null
          id: number
          notes: string | null
          payment_method: string | null
          payment_status: string | null
          room_id: number | null
          source: string | null
          special_requests: string | null
          status: string | null
          total_price: number
          updated_at: string | null
          updated_by: number | null
        }
        Insert: {
          adults?: number | null
          check_in_date: string
          check_out_date: string
          children?: number | null
          confirmation_code?: string | null
          created_at?: string | null
          created_by?: number | null
          guest_id?: number | null
          id?: number
          notes?: string | null
          payment_method?: string | null
          payment_status?: string | null
          room_id?: number | null
          source?: string | null
          special_requests?: string | null
          status?: string | null
          total_price: number
          updated_at?: string | null
          updated_by?: number | null
        }
        Update: {
          adults?: number | null
          check_in_date?: string
          check_out_date?: string
          children?: number | null
          confirmation_code?: string | null
          created_at?: string | null
          created_by?: number | null
          guest_id?: number | null
          id?: number
          notes?: string | null
          payment_method?: string | null
          payment_status?: string | null
          room_id?: number | null
          source?: string | null
          special_requests?: string | null
          status?: string | null
          total_price?: number
          updated_at?: string | null
          updated_by?: number | null
        }
        Relationships: [
          {
            foreignKeyName: "bookings_created_by_fkey"
            columns: ["created_by"]
            isOneToOne: false
            referencedRelation: "users"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "bookings_guest_id_fkey"
            columns: ["guest_id"]
            isOneToOne: false
            referencedRelation: "guests"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "bookings_room_id_fkey"
            columns: ["room_id"]
            isOneToOne: false
            referencedRelation: "rooms"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "bookings_updated_by_fkey"
            columns: ["updated_by"]
            isOneToOne: false
            referencedRelation: "users"
            referencedColumns: ["id"]
          },
        ]
      }
      cleaning_statuses: {
        Row: {
          cleaned_at: string | null
          cleaned_by: number | null
          created_at: string | null
          id: number
          inspected_at: string | null
          inspected_by: number | null
          notes: string | null
          room_id: number | null
          status: string
          updated_at: string | null
        }
        Insert: {
          cleaned_at?: string | null
          cleaned_by?: number | null
          created_at?: string | null
          id?: number
          inspected_at?: string | null
          inspected_by?: number | null
          notes?: string | null
          room_id?: number | null
          status: string
          updated_at?: string | null
        }
        Update: {
          cleaned_at?: string | null
          cleaned_by?: number | null
          created_at?: string | null
          id?: number
          inspected_at?: string | null
          inspected_by?: number | null
          notes?: string | null
          room_id?: number | null
          status?: string
          updated_at?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "cleaning_statuses_cleaned_by_fkey"
            columns: ["cleaned_by"]
            isOneToOne: false
            referencedRelation: "users"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "cleaning_statuses_inspected_by_fkey"
            columns: ["inspected_by"]
            isOneToOne: false
            referencedRelation: "users"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "cleaning_statuses_room_id_fkey"
            columns: ["room_id"]
            isOneToOne: false
            referencedRelation: "rooms"
            referencedColumns: ["id"]
          },
        ]
      }
      email_templates: {
        Row: {
          body: string
          created_at: string | null
          id: number
          is_active: boolean | null
          name: string
          subject: string
          updated_at: string | null
          variables: Json | null
        }
        Insert: {
          body: string
          created_at?: string | null
          id?: number
          is_active?: boolean | null
          name: string
          subject: string
          updated_at?: string | null
          variables?: Json | null
        }
        Update: {
          body?: string
          created_at?: string | null
          id?: number
          is_active?: boolean | null
          name?: string
          subject?: string
          updated_at?: string | null
          variables?: Json | null
        }
        Relationships: []
      }
      expenses: {
        Row: {
          amount: number
          category: string
          created_at: string | null
          created_by: number | null
          description: string | null
          expense_date: string
          id: number
          paid_by: number | null
          payment_method: string | null
          property_id: number | null
          receipt_image: string | null
          room_id: number | null
          status: string | null
          updated_at: string | null
        }
        Insert: {
          amount: number
          category: string
          created_at?: string | null
          created_by?: number | null
          description?: string | null
          expense_date: string
          id?: number
          paid_by?: number | null
          payment_method?: string | null
          property_id?: number | null
          receipt_image?: string | null
          room_id?: number | null
          status?: string | null
          updated_at?: string | null
        }
        Update: {
          amount?: number
          category?: string
          created_at?: string | null
          created_by?: number | null
          description?: string | null
          expense_date?: string
          id?: number
          paid_by?: number | null
          payment_method?: string | null
          property_id?: number | null
          receipt_image?: string | null
          room_id?: number | null
          status?: string | null
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
            foreignKeyName: "expenses_paid_by_fkey"
            columns: ["paid_by"]
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
          },
          {
            foreignKeyName: "expenses_room_id_fkey"
            columns: ["room_id"]
            isOneToOne: false
            referencedRelation: "rooms"
            referencedColumns: ["id"]
          },
        ]
      }
      general_settings: {
        Row: {
          created_at: string | null
          description: string | null
          id: number
          setting_group: string | null
          setting_key: string
          setting_value: string | null
          updated_at: string | null
        }
        Insert: {
          created_at?: string | null
          description?: string | null
          id?: number
          setting_group?: string | null
          setting_key: string
          setting_value?: string | null
          updated_at?: string | null
        }
        Update: {
          created_at?: string | null
          description?: string | null
          id?: number
          setting_group?: string | null
          setting_key?: string
          setting_value?: string | null
          updated_at?: string | null
        }
        Relationships: []
      }
      guests: {
        Row: {
          address: string | null
          city: string | null
          country: string | null
          created_at: string | null
          email: string | null
          first_name: string
          id: number
          id_number: string | null
          id_type: string | null
          last_name: string
          notes: string | null
          phone: string | null
          state: string | null
          updated_at: string | null
          zip_code: string | null
        }
        Insert: {
          address?: string | null
          city?: string | null
          country?: string | null
          created_at?: string | null
          email?: string | null
          first_name: string
          id?: number
          id_number?: string | null
          id_type?: string | null
          last_name: string
          notes?: string | null
          phone?: string | null
          state?: string | null
          updated_at?: string | null
          zip_code?: string | null
        }
        Update: {
          address?: string | null
          city?: string | null
          country?: string | null
          created_at?: string | null
          email?: string | null
          first_name?: string
          id?: number
          id_number?: string | null
          id_type?: string | null
          last_name?: string
          notes?: string | null
          phone?: string | null
          state?: string | null
          updated_at?: string | null
          zip_code?: string | null
        }
        Relationships: []
      }
      invoice_templates: {
        Row: {
          created_at: string | null
          footer: string | null
          header: string | null
          id: number
          is_active: boolean | null
          logo_path: string | null
          name: string
          template: string
          updated_at: string | null
          variables: Json | null
        }
        Insert: {
          created_at?: string | null
          footer?: string | null
          header?: string | null
          id?: number
          is_active?: boolean | null
          logo_path?: string | null
          name: string
          template: string
          updated_at?: string | null
          variables?: Json | null
        }
        Update: {
          created_at?: string | null
          footer?: string | null
          header?: string | null
          id?: number
          is_active?: boolean | null
          logo_path?: string | null
          name?: string
          template?: string
          updated_at?: string | null
          variables?: Json | null
        }
        Relationships: []
      }
      maintenance_records: {
        Row: {
          assigned_to: number | null
          completed_date: string | null
          cost: number | null
          created_at: string | null
          description: string
          id: number
          issue_type: string
          notes: string | null
          priority: string | null
          reported_by: number | null
          reported_date: string | null
          room_id: number | null
          scheduled_date: string | null
          status: string | null
          updated_at: string | null
        }
        Insert: {
          assigned_to?: number | null
          completed_date?: string | null
          cost?: number | null
          created_at?: string | null
          description: string
          id?: number
          issue_type: string
          notes?: string | null
          priority?: string | null
          reported_by?: number | null
          reported_date?: string | null
          room_id?: number | null
          scheduled_date?: string | null
          status?: string | null
          updated_at?: string | null
        }
        Update: {
          assigned_to?: number | null
          completed_date?: string | null
          cost?: number | null
          created_at?: string | null
          description?: string
          id?: number
          issue_type?: string
          notes?: string | null
          priority?: string | null
          reported_by?: number | null
          reported_date?: string | null
          room_id?: number | null
          scheduled_date?: string | null
          status?: string | null
          updated_at?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "maintenance_records_assigned_to_fkey"
            columns: ["assigned_to"]
            isOneToOne: false
            referencedRelation: "users"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "maintenance_records_reported_by_fkey"
            columns: ["reported_by"]
            isOneToOne: false
            referencedRelation: "users"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "maintenance_records_room_id_fkey"
            columns: ["room_id"]
            isOneToOne: false
            referencedRelation: "rooms"
            referencedColumns: ["id"]
          },
        ]
      }
      message_templates: {
        Row: {
          body: string
          created_at: string | null
          id: number
          is_active: boolean | null
          name: string
          subject: string | null
          template_type: string
          updated_at: string | null
          variables: Json | null
        }
        Insert: {
          body: string
          created_at?: string | null
          id?: number
          is_active?: boolean | null
          name: string
          subject?: string | null
          template_type: string
          updated_at?: string | null
          variables?: Json | null
        }
        Update: {
          body?: string
          created_at?: string | null
          id?: number
          is_active?: boolean | null
          name?: string
          subject?: string | null
          template_type?: string
          updated_at?: string | null
          variables?: Json | null
        }
        Relationships: []
      }
      owners: {
        Row: {
          address: string | null
          city: string | null
          country: string | null
          created_at: string | null
          email: string | null
          first_name: string
          id: number
          is_active: boolean | null
          last_name: string
          notes: string | null
          payment_details: Json | null
          phone: string | null
          state: string | null
          tax_id: string | null
          updated_at: string | null
          zip_code: string | null
        }
        Insert: {
          address?: string | null
          city?: string | null
          country?: string | null
          created_at?: string | null
          email?: string | null
          first_name: string
          id?: number
          is_active?: boolean | null
          last_name: string
          notes?: string | null
          payment_details?: Json | null
          phone?: string | null
          state?: string | null
          tax_id?: string | null
          updated_at?: string | null
          zip_code?: string | null
        }
        Update: {
          address?: string | null
          city?: string | null
          country?: string | null
          created_at?: string | null
          email?: string | null
          first_name?: string
          id?: number
          is_active?: boolean | null
          last_name?: string
          notes?: string | null
          payment_details?: Json | null
          phone?: string | null
          state?: string | null
          tax_id?: string | null
          updated_at?: string | null
          zip_code?: string | null
        }
        Relationships: []
      }
      properties: {
        Row: {
          address: string
          city: string
          country: string
          created_at: string | null
          description: string | null
          email: string | null
          id: number
          is_active: boolean | null
          name: string
          phone: string | null
          state: string
          updated_at: string | null
          zip_code: string
        }
        Insert: {
          address: string
          city: string
          country: string
          created_at?: string | null
          description?: string | null
          email?: string | null
          id?: number
          is_active?: boolean | null
          name: string
          phone?: string | null
          state: string
          updated_at?: string | null
          zip_code: string
        }
        Update: {
          address?: string
          city?: string
          country?: string
          created_at?: string | null
          description?: string | null
          email?: string | null
          id?: number
          is_active?: boolean | null
          name?: string
          phone?: string | null
          state?: string
          updated_at?: string | null
          zip_code?: string
        }
        Relationships: []
      }
      property_settings: {
        Row: {
          created_at: string | null
          id: number
          property_id: number | null
          setting_key: string
          setting_value: string | null
          updated_at: string | null
        }
        Insert: {
          created_at?: string | null
          id?: number
          property_id?: number | null
          setting_key: string
          setting_value?: string | null
          updated_at?: string | null
        }
        Update: {
          created_at?: string | null
          id?: number
          property_id?: number | null
          setting_key?: string
          setting_value?: string | null
          updated_at?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "property_settings_property_id_fkey"
            columns: ["property_id"]
            isOneToOne: false
            referencedRelation: "properties"
            referencedColumns: ["id"]
          },
        ]
      }
      room_images: {
        Row: {
          caption: string | null
          created_at: string | null
          id: number
          image_path: string
          is_primary: boolean | null
          room_id: number | null
          updated_at: string | null
        }
        Insert: {
          caption?: string | null
          created_at?: string | null
          id?: number
          image_path: string
          is_primary?: boolean | null
          room_id?: number | null
          updated_at?: string | null
        }
        Update: {
          caption?: string | null
          created_at?: string | null
          id?: number
          image_path?: string
          is_primary?: boolean | null
          room_id?: number | null
          updated_at?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "room_images_room_id_fkey"
            columns: ["room_id"]
            isOneToOne: false
            referencedRelation: "rooms"
            referencedColumns: ["id"]
          },
        ]
      }
      room_types: {
        Row: {
          amenities: Json | null
          base_price: number
          capacity: number
          created_at: string | null
          description: string | null
          id: number
          name: string
          property_id: number | null
          updated_at: string | null
        }
        Insert: {
          amenities?: Json | null
          base_price: number
          capacity: number
          created_at?: string | null
          description?: string | null
          id?: number
          name: string
          property_id?: number | null
          updated_at?: string | null
        }
        Update: {
          amenities?: Json | null
          base_price?: number
          capacity?: number
          created_at?: string | null
          description?: string | null
          id?: number
          name?: string
          property_id?: number | null
          updated_at?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "room_types_property_id_fkey"
            columns: ["property_id"]
            isOneToOne: false
            referencedRelation: "properties"
            referencedColumns: ["id"]
          },
        ]
      }
      rooms: {
        Row: {
          amenities: Json | null
          base_price: number | null
          cleaning_status: string | null
          created_at: string | null
          description: string | null
          floor: number | null
          id: number
          is_active: boolean | null
          last_cleaned_at: string | null
          last_cleaned_by: number | null
          last_renovated: string | null
          max_occupancy: number | null
          owner_id: number | null
          property_id: number | null
          room_number: string
          room_type_id: number | null
          size: string | null
          status: string | null
          updated_at: string | null
        }
        Insert: {
          amenities?: Json | null
          base_price?: number | null
          cleaning_status?: string | null
          created_at?: string | null
          description?: string | null
          floor?: number | null
          id?: number
          is_active?: boolean | null
          last_cleaned_at?: string | null
          last_cleaned_by?: number | null
          last_renovated?: string | null
          max_occupancy?: number | null
          owner_id?: number | null
          property_id?: number | null
          room_number: string
          room_type_id?: number | null
          size?: string | null
          status?: string | null
          updated_at?: string | null
        }
        Update: {
          amenities?: Json | null
          base_price?: number | null
          cleaning_status?: string | null
          created_at?: string | null
          description?: string | null
          floor?: number | null
          id?: number
          is_active?: boolean | null
          last_cleaned_at?: string | null
          last_cleaned_by?: number | null
          last_renovated?: string | null
          max_occupancy?: number | null
          owner_id?: number | null
          property_id?: number | null
          room_number?: string
          room_type_id?: number | null
          size?: string | null
          status?: string | null
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
          },
        ]
      }
      user_roles: {
        Row: {
          created_at: string | null
          description: string | null
          id: number
          name: string
          permissions: Json | null
          updated_at: string | null
        }
        Insert: {
          created_at?: string | null
          description?: string | null
          id?: number
          name: string
          permissions?: Json | null
          updated_at?: string | null
        }
        Update: {
          created_at?: string | null
          description?: string | null
          id?: number
          name?: string
          permissions?: Json | null
          updated_at?: string | null
        }
        Relationships: []
      }
      users: {
        Row: {
          avatar: string | null
          created_at: string | null
          email: string
          email_verified_at: string | null
          id: number
          last_active: string | null
          name: string
          password: string | null
          phone: string | null
          remember_token: string | null
          role: string | null
          updated_at: string | null
        }
        Insert: {
          avatar?: string | null
          created_at?: string | null
          email: string
          email_verified_at?: string | null
          id?: number
          last_active?: string | null
          name: string
          password?: string | null
          phone?: string | null
          remember_token?: string | null
          role?: string | null
          updated_at?: string | null
        }
        Update: {
          avatar?: string | null
          created_at?: string | null
          email?: string
          email_verified_at?: string | null
          id?: number
          last_active?: string | null
          name?: string
          password?: string | null
          phone?: string | null
          remember_token?: string | null
          role?: string | null
          updated_at?: string | null
        }
        Relationships: []
      }
    }
    Views: {
      [_ in never]: never
    }
    Functions: {
      [_ in never]: never
    }
    Enums: {
      [_ in never]: never
    }
    CompositeTypes: {
      [_ in never]: never
    }
  }
}

type DefaultSchema = Database[Extract<keyof Database, "public">]

export type Tables<
  DefaultSchemaTableNameOrOptions extends
    | keyof (DefaultSchema["Tables"] & DefaultSchema["Views"])
    | { schema: keyof Database },
  TableName extends DefaultSchemaTableNameOrOptions extends {
    schema: keyof Database
  }
    ? keyof (Database[DefaultSchemaTableNameOrOptions["schema"]]["Tables"] &
        Database[DefaultSchemaTableNameOrOptions["schema"]]["Views"])
    : never = never,
> = DefaultSchemaTableNameOrOptions extends { schema: keyof Database }
  ? (Database[DefaultSchemaTableNameOrOptions["schema"]]["Tables"] &
      Database[DefaultSchemaTableNameOrOptions["schema"]]["Views"])[TableName] extends {
      Row: infer R
    }
    ? R
    : never
  : DefaultSchemaTableNameOrOptions extends keyof (DefaultSchema["Tables"] &
        DefaultSchema["Views"])
    ? (DefaultSchema["Tables"] &
        DefaultSchema["Views"])[DefaultSchemaTableNameOrOptions] extends {
        Row: infer R
      }
      ? R
      : never
    : never

export type TablesInsert<
  DefaultSchemaTableNameOrOptions extends
    | keyof DefaultSchema["Tables"]
    | { schema: keyof Database },
  TableName extends DefaultSchemaTableNameOrOptions extends {
    schema: keyof Database
  }
    ? keyof Database[DefaultSchemaTableNameOrOptions["schema"]]["Tables"]
    : never = never,
> = DefaultSchemaTableNameOrOptions extends { schema: keyof Database }
  ? Database[DefaultSchemaTableNameOrOptions["schema"]]["Tables"][TableName] extends {
      Insert: infer I
    }
    ? I
    : never
  : DefaultSchemaTableNameOrOptions extends keyof DefaultSchema["Tables"]
    ? DefaultSchema["Tables"][DefaultSchemaTableNameOrOptions] extends {
        Insert: infer I
      }
      ? I
      : never
    : never

export type TablesUpdate<
  DefaultSchemaTableNameOrOptions extends
    | keyof DefaultSchema["Tables"]
    | { schema: keyof Database },
  TableName extends DefaultSchemaTableNameOrOptions extends {
    schema: keyof Database
  }
    ? keyof Database[DefaultSchemaTableNameOrOptions["schema"]]["Tables"]
    : never = never,
> = DefaultSchemaTableNameOrOptions extends { schema: keyof Database }
  ? Database[DefaultSchemaTableNameOrOptions["schema"]]["Tables"][TableName] extends {
      Update: infer U
    }
    ? U
    : never
  : DefaultSchemaTableNameOrOptions extends keyof DefaultSchema["Tables"]
    ? DefaultSchema["Tables"][DefaultSchemaTableNameOrOptions] extends {
        Update: infer U
      }
      ? U
      : never
    : never

export type Enums<
  DefaultSchemaEnumNameOrOptions extends
    | keyof DefaultSchema["Enums"]
    | { schema: keyof Database },
  EnumName extends DefaultSchemaEnumNameOrOptions extends {
    schema: keyof Database
  }
    ? keyof Database[DefaultSchemaEnumNameOrOptions["schema"]]["Enums"]
    : never = never,
> = DefaultSchemaEnumNameOrOptions extends { schema: keyof Database }
  ? Database[DefaultSchemaEnumNameOrOptions["schema"]]["Enums"][EnumName]
  : DefaultSchemaEnumNameOrOptions extends keyof DefaultSchema["Enums"]
    ? DefaultSchema["Enums"][DefaultSchemaEnumNameOrOptions]
    : never

export type CompositeTypes<
  PublicCompositeTypeNameOrOptions extends
    | keyof DefaultSchema["CompositeTypes"]
    | { schema: keyof Database },
  CompositeTypeName extends PublicCompositeTypeNameOrOptions extends {
    schema: keyof Database
  }
    ? keyof Database[PublicCompositeTypeNameOrOptions["schema"]]["CompositeTypes"]
    : never = never,
> = PublicCompositeTypeNameOrOptions extends { schema: keyof Database }
  ? Database[PublicCompositeTypeNameOrOptions["schema"]]["CompositeTypes"][CompositeTypeName]
  : PublicCompositeTypeNameOrOptions extends keyof DefaultSchema["CompositeTypes"]
    ? DefaultSchema["CompositeTypes"][PublicCompositeTypeNameOrOptions]
    : never

export const Constants = {
  public: {
    Enums: {},
  },
} as const
