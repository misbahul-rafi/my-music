import { NextResponse } from 'next/server';
import {prisma} from '@/lib/prisma';
import * as bcrypt from "bcrypt-ts";

export async function POST(req: Request) {
  const { username, password, name } = await req.json();
  try {
    if (!username || !password || !name) {
      return NextResponse.json({ error: "Please provide username, password, and name." }, { status: 400 });
    }
    const existingUser = await prisma.user.findUnique({
      where: { username },
    });

    if (existingUser) {
      return NextResponse.json({ error: "Username already exists." }, { status: 409 });
    }
    // const salt = genSaltSync(10);
    const hashPassword = await bcrypt.hash(password, 10);
    const newUser = await prisma.user.create({
      data: {
        username,
        password: hashPassword,
        name,
      },
    });

    return NextResponse.json({ user: newUser }, { status: 201 });
  } catch (error) {
    console.error('Error during registration:', error);
    return NextResponse.json({ error: "Internal Server Error" }, { status: 500 });
  }
}
