export interface JwtPayload {
  iat: number;
  exp: number;
  roles: string[];
  username: string;
  id: string;
}
