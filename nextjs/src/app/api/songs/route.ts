import { PrismaClient } from '@prisma/client';
import { NextResponse } from 'next/server';
import { getServerSession } from "next-auth/next"
import { authOptions } from '@/lib/auth';
import { Song } from '@/types';


const prisma = new PrismaClient();
export async function POST(req: Request) {
  try {
    const session = await getServerSession(authOptions)
    if (!session) {
      return NextResponse.json({ error: 'Unauthorized' }, { status: 401 });
    }

    const { title, artist, youtubeUrl, textLyrics }: Song & { textLyrics: string } = await req.json();

    if (!title || !artist || !youtubeUrl) {
      return NextResponse.json({ error: 'All fields are required' }, { status: 400 });
    }

    try {
      const response = await fetch(`${process.env.NEXT_PUBLIC_FLASK_API}/songs`, {
        method: "POST",
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          youtubeUrl,
          userId: session.user.id,
          textLyrics,
        }),
      });

      if (!response.ok) {
        const errorData = await response.json();
        return NextResponse.json({ error: errorData.message }, { status: response.status });
      }

      const fileData = await response.json();

      const result = await prisma.song.create({
        data: {
          title,
          artist,
          duration: fileData.duration,
          fileName: fileData.file_name,
          youtubeUrl,
          userId: session.user?.id,
        },
      });

      return NextResponse.json(result, { status: 201 });
    } catch (error) {
      console.error('Error while downloading:', error);
      return NextResponse.json({ error: 'Error Downloading: ' + error }, { status: 400 });
    }
  } catch (error) {
    console.error('Error creating song:', error);
    return NextResponse.json({ error: 'Error creating song' }, { status: 500 });
  }
}

export async function GET() {
  try {
    const songs = await prisma.song.findMany();
    return NextResponse.json(songs);
  } catch (error) {
    console.error('Error fetching songs:', error);
    return NextResponse.json({ error: 'Error fetching songs' }, { status: 500 });
  }
}
