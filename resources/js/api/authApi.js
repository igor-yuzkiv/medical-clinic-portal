import http from "@/plugins/http.js";

export function loginRequest(data) {
    return http.post('auth/login', data)
}

export function logoutRequest() {
    return http.post('auth/logout')
}


export function fetchCurrentUser() {
    return http.get(`auth/user`)
}
