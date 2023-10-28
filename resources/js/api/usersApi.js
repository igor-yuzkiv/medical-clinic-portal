import {ApiResource} from "@/api/composable/apiResource.js";
import http from "@/plugins/http.js";

const usersApi = new ApiResource('/users');

usersApi.search = function (keyword, role = null) {
    const filters = [
        `search(keyword:${keyword})`,
    ]

    if (role) {
        filters.push(`role(${role})`)
    }

    return usersApi.getList({
        filters: filters,
        query  : {
            paginate: false,
            limit   : 100,
        }
    })
}

export function loginRequest(data) {
    return http.post('auth/login', data)
}

export function logoutRequest() {
    return http.post('auth/logout')
}

export function fetchCurrentUser() {
    return http.get(`auth/user`)
}

export {
    usersApi
}
