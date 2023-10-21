import {ApiResource} from "@/api/apiResource.js";

const usersApi = new ApiResource('/users');

usersApi.search = function (keyword, role = null) {
    const filters = [
        `search(${keyword})`
    ]

    if (role) {
        filters.push(`role(${role})`)
    }

    return usersApi.getList({
        query: {
            paginate: false,
            filters : filters,
        }
    })
}

export {
    usersApi
}
