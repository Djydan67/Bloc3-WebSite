import { useState, useEffect } from "react";

export const useModerationUsers = (token: string | null) => {
    const [users, setUsers] = useState<{ userId: number, username: string }[]>([]);
    const [error, setError] = useState<string | null>(null);
  
    useEffect(() => {
      const fetchUsers = async () => {
        if (!token) {
          setError("Token is missing");
          return;
        }
  
        try {
          const response = await fetch(
            "http://localhost:8888/blog/dofusweb/Bloc3-WebSite/index.php/?ctrl=User&action=getUsersForModeration",
            {
              method: "GET",
              headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "application/json",
              },
            }
          );
  
          if (!response.ok) {
            throw new Error("Failed to fetch users");
          }
  
          const data = await response.json();
          setUsers(data.map((user: any) => ({ userId: user.user_id, username: user.user_pseudo })));
          setError(null);
        } catch (err: any) {
          setError(err.message);
        }
      };
  
      fetchUsers();
    }, [token]);
  
    return { users, error };
  };
  