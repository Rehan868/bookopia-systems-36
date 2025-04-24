
import React, { useState } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Plus, Trash2, DoorClosed } from 'lucide-react';
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table';
import { useToast } from '@/hooks/use-toast';

interface OwnerRoomsListProps {
  ownerId: string;
  isEditing?: boolean;
}

export const OwnerRoomsList = ({ ownerId, isEditing = false }: OwnerRoomsListProps) => {
  const { toast } = useToast();
  const [ownerRoomsList, setOwnerRoomsList] = useState<any[]>([]);

  // Mock data for rooms would ideally come from a proper API call
  const ownerRoomDetails = ownerRoomsList.map(or => ({
    ...or,
    roomDetails: { number: "101", property: "Sample Property", type: "Standard", status: "Available" }
  }));

  const availableRooms = [
    { id: "r1", number: "102", property: "Sample Property" },
    { id: "r2", number: "103", property: "Sample Property" }
  ];

  const handleAddRoom = (roomId: string) => {
    const newOwnerRoom = {
      id: `or${Date.now()}`,
      ownerId,
      roomId,
      assignedDate: new Date().toISOString().split('T')[0]
    };
    setOwnerRoomsList([...ownerRoomsList, newOwnerRoom]);
    toast({
      title: "Room Added",
      description: "Room has been successfully assigned to the owner.",
    });
  };

  const handleDeleteRoom = (roomId: string) => {
    setOwnerRoomsList(ownerRoomsList.filter(or => or.roomId !== roomId));
    toast({
      title: "Room Removed",
      description: "Room has been removed from the owner's portfolio.",
    });
  };

  return (
    <Card className="mt-6">
      <CardHeader className="flex flex-row items-center justify-between">
        <CardTitle>Owner Rooms</CardTitle>
        {isEditing && availableRooms.length > 0 && (
          <div className="flex gap-2">
            <select
              className="border rounded p-2"
              onChange={(e) => e.target.value && handleAddRoom(e.target.value)}
              value=""
            >
              <option value="">Add Room</option>
              {availableRooms.map((room) => (
                <option key={room.id} value={room.id}>
                  {room.number} - {room.property}
                </option>
              ))}
            </select>
            <Button size="icon">
              <Plus className="h-4 w-4" />
            </Button>
          </div>
        )}
      </CardHeader>
      <CardContent>
        {ownerRoomDetails.length > 0 ? (
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Room Number</TableHead>
                <TableHead>Property</TableHead>
                <TableHead>Type</TableHead>
                <TableHead>Status</TableHead>
                {isEditing && <TableHead>Actions</TableHead>}
              </TableRow>
            </TableHeader>
            <TableBody>
              {ownerRoomDetails.map((or) => (
                <TableRow key={or.id}>
                  <TableCell>{or.roomDetails?.number}</TableCell>
                  <TableCell>{or.roomDetails?.property}</TableCell>
                  <TableCell>{or.roomDetails?.type}</TableCell>
                  <TableCell>{or.roomDetails?.status}</TableCell>
                  {isEditing && (
                    <TableCell>
                      <Button
                        variant="destructive"
                        size="icon"
                        onClick={() => handleDeleteRoom(or.roomId)}
                      >
                        <Trash2 className="h-4 w-4" />
                      </Button>
                    </TableCell>
                  )}
                </TableRow>
              ))}
            </TableBody>
          </Table>
        ) : (
          <div className="flex flex-col items-center justify-center py-8 text-center">
            <DoorClosed className="h-8 w-8 text-muted-foreground mb-2" />
            <p className="text-muted-foreground">No rooms assigned to this owner</p>
          </div>
        )}
      </CardContent>
    </Card>
  );
};
