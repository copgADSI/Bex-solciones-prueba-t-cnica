interface Credentials {
    email: string,
    password: string
}

interface AuthState {
    authUser: object;
    token: string | null;
}

interface RootState {
    auth: AuthState;
}


export {
    Credentials,
    AuthState,
    RootState,
}
