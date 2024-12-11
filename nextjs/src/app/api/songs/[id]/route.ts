import { PrismaClient } from '@prisma/client';
import { NextRequest, NextResponse } from 'next/server';
import {Song} from "@/types"
import { getServerSession } from "next-auth/next"
import { authOptions } from '@/lib/auth';

const prisma = new PrismaClient();

export async function GET(req: NextRequest) {
  const { searchParams } = new URL(req.url);
  const id = searchParams.get('id');

  if (!id) {
    return NextResponse.json({ error: 'ID is required' }, { status: 400 });
  }

  const songId = parseInt(id);
  if (isNaN(songId)) {
    return NextResponse.json({ error: 'Invalid ID format' }, { status: 400 });
  }

  try {
    const song = await prisma.song.findUnique({
      where: { id: songId },
    });
    if (!song) {
      return NextResponse.json({ error: 'Song not found' }, { status: 404 });
    }
    return NextResponse.json(song);
  } catch (error) {
    console.error('Error fetching song:', error);
    return NextResponse.json({ error: 'Error fetching song' }, { status: 500 });
  }
}


export async function PUT(req: Request,) {
  try {
    const { id, title, artist, userId, fileName, textLyrics }: Song & { textLyrics: string } = await req.json();
    const session = await getServerSession(authOptions);
    if (session?.user.id !== userId.toString()) {
      return NextResponse.json({ error: 'User Not Valid' }, { status: 406 });
    }

    if (!id || !title || !artist) {
      return NextResponse.json({ error: 'All fields are required' }, { status: 400 });
    }
    const formData = new FormData();
    formData.append("fileName", fileName);
    formData.append("textLyrics", textLyrics);
    const response = await fetch(`${process.env.NEXT_PUBLIC_FLASK_API}/songs`, {
      method: "PUT",
      body: formData,
    })
    if (!response.ok) {
      const errorData = await response.json();
      return NextResponse.json({ error: errorData.message }, { status: response.status });
    }
    const updatedSong = await prisma.song.update({
      where: { id },
      data: { title, artist },
    });
    return NextResponse.json(updatedSong);
  } catch (error) {
    console.error('Error updating song:', error);
    return NextResponse.json({ error: 'Error updating song' }, { status: 500 });
  }
}

export async function DELETE(req: Request) {
  try {
    const { id }: { id: number } = await req.json();

    if (!id) {
      return NextResponse.json({ error: 'ID is required' }, { status: 400 });
    }

    await prisma.song.delete({
      where: { id },
    });
    return NextResponse.json({}, { status: 204 });
  } catch (error) {
    console.error('Error deleting song:', error);
    return NextResponse.json({ error: 'Error deleting song' }, { status: 500 });
  }
}
