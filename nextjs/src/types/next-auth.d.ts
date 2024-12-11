import { DefaultSession } from "next-auth";

declare module "next-auth" {
  interface Session {
    user: {
      id: string;
      username: string;
      name: string | undefined
    } & DefaultSession["user"]
  }

  interface User {
    id: string;
    username: string;
    name: string | undefined
  }
}

declare module "next-auth/jwt" {
  interface JWT {
    id: string;
    username: string;
    name: string
  }
}