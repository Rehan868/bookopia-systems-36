
import React, { createContext, useContext, useState, useEffect } from 'react';
import { supabase } from '@/integrations/supabase/client';
import { useToast } from './use-toast';
import { Session, User } from '@supabase/supabase-js';

interface UserData {
  id: string;
  name: string;
  email: string;
  role: string;
  avatar?: string;
}

interface AuthContextType {
  isAuthenticated: boolean;
  user: UserData | null;
  isLoading: boolean;
  login: (email: string, password: string) => Promise<void>;
  logout: () => Promise<void>;
  ownerLogin: (email: string, password: string) => Promise<void>;
  session: Session | null;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export function AuthProvider({ children }: { children: React.ReactNode }) {
  const [session, setSession] = useState<Session | null>(null);
  const [user, setUser] = useState<UserData | null>(null);
  const [isAuthenticated, setIsAuthenticated] = useState<boolean>(false);
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const { toast } = useToast();

  useEffect(() => {
    // Set up the auth state listener
    const { data: { subscription } } = supabase.auth.onAuthStateChange(
      async (event, currentSession) => {
        setSession(currentSession);
        
        if (currentSession?.user) {
          setIsAuthenticated(true);
          
          // Fetch the user profile from our users table
          try {
            setTimeout(async () => {
              const { data: profile } = await supabase
                .from('users')
                .select('*')
                .eq('id', parseInt(currentSession.user.id))
                .single();
              
              if (profile) {
                setUser({
                  id: profile.id.toString(),
                  name: profile.name,
                  email: profile.email,
                  role: profile.role,
                  avatar: profile.avatar
                });
              }
            }, 0);
          } catch (error) {
            console.error('Error fetching user profile:', error);
          }
        } else {
          setUser(null);
          setIsAuthenticated(false);
        }
      }
    );

    // Check for an existing session
    const initAuth = async () => {
      try {
        setIsLoading(true);
        const { data: { session: currentSession } } = await supabase.auth.getSession();
        
        if (currentSession?.user) {
          setSession(currentSession);
          setIsAuthenticated(true);
          
          // Fetch user profile
          const { data: profile } = await supabase
            .from('users')
            .select('*')
            .eq('id', parseInt(currentSession.user.id))
            .single();
          
          if (profile) {
            setUser({
              id: profile.id.toString(),
              name: profile.name,
              email: profile.email,
              role: profile.role,
              avatar: profile.avatar
            });
          }
        }
      } catch (error) {
        console.error('Error during auth initialization:', error);
      } finally {
        setIsLoading(false);
      }
    };

    initAuth();

    return () => {
      subscription.unsubscribe();
    };
  }, []);

  const login = async (email: string, password: string) => {
    try {
      const { data, error } = await supabase.auth.signInWithPassword({
        email,
        password
      });

      if (error) throw error;
      
      // Get user role and redirect accordingly
      const { data: profile } = await supabase
        .from('users')
        .select('role')
        .eq('id', data.user.id)
        .single();
      
      if (profile?.role === 'owner') {
        toast({
          title: "Owner login successful",
          description: "You have been logged in as an owner"
        });
      } else {
        toast({
          title: "Login successful",
          description: "You have been logged in successfully"
        });
      }
      
      return;
    } catch (error: any) {
      console.error('Login error:', error);
      toast({
        title: "Login failed",
        description: error.message || "Failed to log in. Please check your credentials.",
        variant: "destructive"
      });
      throw error;
    }
  };
  
  const ownerLogin = async (email: string, password: string) => {
    try {
      // Use the same login method but we'll check role afterward
      const { data, error } = await supabase.auth.signInWithPassword({
        email,
        password
      });

      if (error) throw error;
      
      // Check if user has owner role
      const { data: profile } = await supabase
        .from('users')
        .select('role')
        .eq('id', parseInt(data.user.id))
        .single();
      
      if (profile?.role !== 'owner') {
        // If not an owner, sign out and throw error
        await supabase.auth.signOut();
        throw new Error('Access denied. Owner credentials required.');
      }
      
      toast({
        title: "Owner login successful",
        description: "You have been logged in as an owner"
      });
      
      return;
    } catch (error: any) {
      console.error('Owner login error:', error);
      toast({
        title: "Login failed",
        description: error.message || "Failed to log in as owner. Please check your credentials.",
        variant: "destructive"
      });
      throw error;
    }
  };
  
  const logout = async () => {
    try {
      await supabase.auth.signOut();
      toast({
        title: "Logged out",
        description: "You have been logged out successfully"
      });
    } catch (error: any) {
      console.error('Logout error:', error);
      toast({
        title: "Logout failed",
        description: error.message || "An error occurred during logout",
        variant: "destructive"
      });
    }
  };

  return (
    <AuthContext.Provider value={{ isAuthenticated, user, isLoading, login, logout, ownerLogin, session }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  const context = useContext(AuthContext);
  if (context === undefined) {
    throw new Error('useAuth must be used within an AuthProvider');
  }
  return context;
}
