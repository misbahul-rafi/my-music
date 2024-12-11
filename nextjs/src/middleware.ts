
// import { NextResponse } from 'next/server'
import type { NextRequest } from 'next/server'
// import { getServerSession } from "next-auth/next"
// import { authOptions } from '@/app/api/auth/[...nextauth]/route';
// import { getToken } from "next-auth/jwt";

export async function middleware(req: NextRequest) {
  console.log(req)
  // if (req.nextUrl.pathname.startsWith('/profile')) {
  //   const session = await getServerSession(authOptions)
  //   const token = await getToken({ req });
  //   console.log(session)
  //   console.log(token)
  //   if(!session) return NextResponse.redirect(new URL('/login', req.url))
  // }
}

export const config = {
  matcher: ['/songs/:path*', '/profile/:path*']
}