// lib/auth.ts
import CredentialsProvider from "next-auth/providers/credentials";
import * as bcrypt from 'bcrypt-ts';
import { PrismaAdapter } from "@next-auth/prisma-adapter";
import { Adapter } from "next-auth/adapters";
import { Session } from "next-auth";
import { JWT } from "next-auth/jwt";
import { NextAuthOptions } from "next-auth";
import {prisma} from '@/lib/prisma'
class AuthError extends Error {
  code: string;

  constructor(code: string) {
    super();
    this.code = code;
  }
}
export const authOptions: NextAuthOptions = {
  adapter: PrismaAdapter(prisma) as Adapter,
  providers: [
    CredentialsProvider({
      name: "credentials",
      credentials: {
        username: { label: "Username", type: "text" },
        password: { label: "Password", type: "password" }
      },
      authorize: async (credentials) => {
        console.log("Received credentials:", credentials);
        try {
          const user = await prisma.user.findUnique({
            where: {
              username: credentials?.username as string,
            }
          })
          console.log("User found:", user);
          if (!user) {
            console.log("Throwing AuthError: User Not Found");
            throw new AuthError("User Not Found");
          }
          const isValid = await bcrypt.compare(credentials?.password as string, user.password)
          console.log("Password valid:", isValid);
          if ( !isValid) {
            throw new AuthError("Username and Passowrd Not Match");
          }
          return {
            id: user.id,
            username: user.username,
            name: user.name || "",
          }
        } catch (error) {
          if (error instanceof Error) {
            throw error;
          }
          throw new Error("Internal Error")
        }
      }
    })
  ],
  session: {
    strategy: "jwt"
  },
  secret: process.env.NEXTAUTH_SECRET,
  callbacks: {
    async session({ session, token }: { session: Session; token: JWT }){
      if(session.user) {
        session.user.id = token.id as string;
        session.user.username = token.username as string;
        session.user.name = token.name as string;
      }
      return session
    },
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    async jwt({token, user} : { token: JWT; user?: any }){
      if(user){
        token.id = user.id || '';
        token.username = user.username;
        token.name = user.name || '';
      }
      return token;
    }
  }
}