
import { useQuery, useMutation, useQueryClient  } from "@tanstack/react-query";
import { Song } from "@/types";
interface SongPayload {
  songData: Song;
  textLyrics: string;
}
export const useSongs = () => {
  return useQuery({
    queryKey: ['songs'],
    queryFn: async () => {
      const response = await fetch('/api/songs', {
        method: 'GET',
      });

      if (!response.ok) {
        throw new Error('Failed to fetch songs');
      }

      return response.json();
    },
  });
};

export const useSongsId = ({songId}: {songId: string}) => {
  return useQuery({
    queryKey: ['songs', songId],
    queryFn: async () => {
      const response = await fetch(`/api/songs/${songId}`, {
        method: 'GET',
      });

      if (!response.ok) {
        throw new Error('Failed to fetch songs');
      }
      
      return response.json();
    },
  });
};

export const useCreateSong = (createSuccess: () => void) => {
  const queryClient = useQueryClient();
  return useMutation({
    mutationFn: async ({ songData, textLyrics }: SongPayload) => {
      const response = await fetch('/api/songs', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ ...songData, textLyrics }),
      });

      if (!response.ok) {
        const errorData = await response.json();
        switch (response.status) {
          case 400:
            throw new Error(errorData.error || 'Bad Request: Invalid data');
          case 404:
            throw new Error('Not Found: Unable to find the requested resource');
          case 500:
            throw new Error('Internal Server Error: Something went wrong on the server');
          default:
            throw new Error('An unexpected error occurred');
        }
      }

      return "song created";
    },
    onSuccess: () => {
      createSuccess();
      queryClient.invalidateQueries({ queryKey: ['songs'] });
    },
  });
};

export const useUpdateSong = (onSuccessCallback: () => void) => {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async ({ songData, textLyrics }: SongPayload) => {
      const response = await fetch(`/api/songs/${songData.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ ...songData, textLyrics }),
      });

      if (!response.ok) {
        const errorData = await response.json();
        console.error(errorData);
        throw new Error('Failed to update song');
      }

      return "success";
    },
    onSuccess: () => {
      onSuccessCallback();
      queryClient.invalidateQueries({ queryKey: ['songs'] });
    },
  });
};

export const useDeleteSong = (onSuccessCallback: () => void) => {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (songId: string) => {
      const response = await fetch(`/api/songs/${songId}`, {
        method: 'DELETE',
      });

      if (!response.ok) {
        const errorData = await response.json();
        console.error(errorData);
        throw new Error('Failed to delete song');
      }

      return "song deleted";
    },
    onSuccess: () => {
      onSuccessCallback();
      queryClient.invalidateQueries({ queryKey: ['songs'] });
    },
  });
};
export const useDownloadSong = (onSuccessCallback: () => void) => {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (formData: { title: string; youtubeUrl: string }) => {
      const response = await fetch(`${process.env.NEXT_PUBLIC_FLASK_API}/download`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
      });

      if (!response.ok) {
        const errorData = await response.json();
        if(errorData?.message){
          throw new Error(errorData.message)
        }
        console.error(errorData?.message);
        throw new Error('Failed to update song');
      }

      return response.json();
    },
    onSuccess: () => {
      onSuccessCallback();
      queryClient.invalidateQueries({ queryKey: ['songs'] });
    },
  });
};