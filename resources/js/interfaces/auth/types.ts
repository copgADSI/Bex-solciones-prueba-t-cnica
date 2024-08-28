// types.ts
export interface AuthState {
    authUser: any; // Cambia 'any' por el tipo adecuado de usuario
    token: string | null;
}

export interface RootState {
    auth: AuthState;
}
