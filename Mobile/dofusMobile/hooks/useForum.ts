import { useState, useEffect, useCallback } from "react";

const IP = `http://192.168.1.90/Bloc3-WebSite/index.php`;

type Theme = {
  theme_id: string;
  theme_nom: string;
  theme_color: string;
};

type Forum = {
  forum_id?: string;
  forum_titre: string;
  forum_message: string;
  user_id?: string;
  user_pseudo?: string;
  forum_date?: string;
  theme_id?: string;
};

type ForumResponse = {
  reponse_id?: string;
  forum_id?: string;
  reponse_message: string;
  reponse_date?: string;
  user_pseudo?: string;
  user_id?: string;
};

const fetchWithTryCatch = async <T>(
  url: string,
  errorMessage: string,
  options?: RequestInit
): Promise<T> => {
  try {
    const response = await fetch(url, options);
    const responseBody = await response.text(); // Get the raw response body as text

    if (!response.ok) {
      throw new Error(`${errorMessage}: ${response.statusText}`);
    }

    const data = JSON.parse(responseBody);
    return data;
  } catch (error: any) {
    console.error(`${errorMessage}:`, error);
    throw new Error(error.message);
  }
};

export const useForums = () => {
  const [themes, setThemes] = useState<Theme[]>([]);
  const [forums, setForums] = useState<Forum[]>([]);
  const [responses, setResponses] = useState<ForumResponse[]>([]);
  const [selectedTheme, setSelectedTheme] = useState<string | null>(null);
  const [error, setError] = useState<Error | null>(null);

  const fetchThemes = useCallback(async () => {
    setError(null);
    try {
      const data = await fetchWithTryCatch<Theme[]>(
        `${IP}?ctrl=forum&action=themes`,
        "Failed to fetch themes"
      );
      setThemes(data);
    } catch (err: any) {
      setError(err);
    }
  }, []);

  useEffect(() => {
    fetchThemes();
  }, [fetchThemes]);

  const fetchForumsByTheme = useCallback(async (themeId: string) => {
    setError(null);
    try {
      const data = await fetchWithTryCatch<{ forums: Forum[] }>(
        `${IP}?ctrl=forum&action=getForumsByTheme&theme_id=${themeId}`,
        "Failed to fetch forums"
      );
      setForums(data.forums);
      setSelectedTheme(themeId);
    } catch (err: any) {
      setError(err);
    }
  }, []);

  const fetchForumResponses = useCallback(async (forumId: string) => {
    setError(null);
    try {
      const data = await fetchWithTryCatch<ForumResponse[]>(
        `${IP}?ctrl=forum&action=getForum&forum_id=${forumId}`,
        "Failed to fetch forum responses"
      );
      const formattedResponses = data.map((response) => ({
        reponse_id: response.reponse_id,
        reponse_message: response.reponse_message,
        reponse_date: response.reponse_date,
        user_pseudo: response.user_pseudo,
      }));

      setResponses(formattedResponses);
    } catch (err: any) {
      setError(err);
    }
  }, []);

  const createForum = useCallback(async (forum: Forum) => {
    setError(null);
    try {
      const response = await fetchWithTryCatch(
        `${IP}?ctrl=forum&action=createForum`,
        "Failed to create forum",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(forum),
        }
      );
    } catch (err: any) {
      setError(err);
    }
  }, []);

  const createResponse = useCallback(async (forumResponse: ForumResponse) => {
    setError(null);
    try {
      const result = await fetchWithTryCatch(
        `${IP}?ctrl=forum&action=createResponse`,
        "Failed to create response",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(forumResponse),
        }
      );
    } catch (err: any) {
      setError(err);
    }
  }, []);

  const handleRefresh = useCallback(async () => {
    try {
      await fetchThemes();
      if (selectedTheme) {
        await fetchForumsByTheme(selectedTheme);
      }
    } catch (err: any) {
      setError(err);
    }
  }, [selectedTheme, fetchThemes, fetchForumsByTheme]);

  return {
    themes,
    forums,
    responses,
    error,
    selectedTheme,
    fetchForumsByTheme,
    createForum,
    fetchForumResponses,
    fetchThemes,
    handleRefresh,
    createResponse, // Added this to the return
  };
};
