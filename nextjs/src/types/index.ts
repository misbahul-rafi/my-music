export interface Song { 
  id: number;
  title: string;
  artist: string;
  fileName: string;
  userId: string;
  youtubeUrl: string;
  duration: number;
}

export interface User{
  id: number
  name: string,
  email?: string,
  image?: string,
  username: string,
}