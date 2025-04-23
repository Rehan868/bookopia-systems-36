
import React from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { Card } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Label } from '@/components/ui/label';
import { useToast } from '@/hooks/use-toast';
import { useOwner } from '@/hooks/useOwners';
import { OwnerRoomsList } from '@/components/owners/OwnerRoomsList';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';

const OwnerEdit = () => {
  const { id } = useParams<{ id: string }>();
  const { data: owner, isLoading, updateOwner } = useOwner(id || '');
  const { toast } = useToast();
  const navigate = useNavigate();
  
  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    
    if (!owner) return;
    
    const form = e.target as HTMLFormElement;
    const formData = new FormData(form);
    
    const updatedOwner = {
      name: formData.get('name') as string,
      email: formData.get('email') as string,
      phone: formData.get('phone') as string,
      payment_info: {
        bank: formData.get('bank') as string,
        account_number: formData.get('accountNumber') as string,
        routing_number: formData.get('routingNumber') as string,
      }
    };
    
    try {
      await updateOwner(updatedOwner);
      toast({
        title: "Owner Updated",
        description: "Owner details have been updated successfully"
      });
    } catch (error) {
      toast({
        variant: "destructive",
        title: "Update Failed",
        description: "There was an error updating the owner."
      });
    }
  };
  
  if (isLoading) return <div className="p-6">Loading...</div>;
  if (!owner) return <div className="p-6">Owner not found</div>;
  
  return (
    <div className="p-6">
      <h1 className="text-2xl font-bold mb-6">Edit Owner</h1>
      
      <Tabs defaultValue="details">
        <TabsList>
          <TabsTrigger value="details">Owner Details</TabsTrigger>
          <TabsTrigger value="properties">Properties</TabsTrigger>
          <TabsTrigger value="revenue">Revenue</TabsTrigger>
        </TabsList>
        
        <TabsContent value="details" className="mt-6">
          <Card className="p-6">
            <form onSubmit={handleSubmit}>
              <div className="space-y-4">
                <div>
                  <Label htmlFor="name">Name</Label>
                  <Input id="name" name="name" defaultValue={owner.name} required />
                </div>
                
                <div>
                  <Label htmlFor="email">Email</Label>
                  <Input id="email" name="email" type="email" defaultValue={owner.email} required />
                </div>
                
                <div>
                  <Label htmlFor="phone">Phone</Label>
                  <Input id="phone" name="phone" defaultValue={owner.phone || ''} />
                </div>
                
                <div className="pt-4 border-t">
                  <h3 className="text-lg font-medium mb-4">Payment Information</h3>
                  
                  <div className="space-y-4">
                    <div>
                      <Label htmlFor="bank">Bank Name</Label>
                      <Input 
                        id="bank" 
                        name="bank" 
                        defaultValue={owner.payment_info?.bank || ''} 
                      />
                    </div>
                    
                    <div>
                      <Label htmlFor="accountNumber">Account Number</Label>
                      <Input 
                        id="accountNumber" 
                        name="accountNumber" 
                        defaultValue={owner.payment_info?.account_number || ''}
                      />
                    </div>
                    
                    <div>
                      <Label htmlFor="routingNumber">Routing Number</Label>
                      <Input 
                        id="routingNumber" 
                        name="routingNumber" 
                        defaultValue={owner.payment_info?.routing_number || ''} 
                      />
                    </div>
                  </div>
                </div>
                
                <div className="flex justify-end gap-2 pt-4">
                  <Button type="button" variant="outline" onClick={() => navigate('/owners')}>
                    Cancel
                  </Button>
                  <Button type="submit">Save Changes</Button>
                </div>
              </div>
            </form>
          </Card>
        </TabsContent>
        
        <TabsContent value="properties" className="mt-6">
          <Card className="p-6">
            <h3 className="text-lg font-medium mb-4">Owner Properties</h3>
            <OwnerRoomsList ownerId={owner.id} />
          </Card>
        </TabsContent>
        
        <TabsContent value="revenue" className="mt-6">
          <Card className="p-6">
            <h3 className="text-lg font-medium mb-4">Revenue Details</h3>
            
            <div className="space-y-4">
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <Label className="text-muted-foreground">Total Properties</Label>
                  <p className="text-2xl font-bold">{owner.properties || 0}</p>
                </div>
                <div>
                  <Label className="text-muted-foreground">Average Occupancy</Label>
                  <p className="text-2xl font-bold">{owner.occupancy || 0}%</p>
                </div>
              </div>
              
              <div>
                <Label className="text-muted-foreground">Total Revenue (YTD)</Label>
                <p className="text-2xl font-bold">${owner.revenue?.toLocaleString() || '0'}</p>
              </div>
              
              <div className="pt-4">
                <Label className="text-muted-foreground mb-2 block">Revenue Breakdown</Label>
                <Textarea 
                  value="No detailed revenue data available yet."
                  readOnly 
                />
              </div>
            </div>
          </Card>
        </TabsContent>
      </Tabs>
    </div>
  );
};

export default OwnerEdit;
