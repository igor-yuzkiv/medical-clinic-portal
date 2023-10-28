import http from "@/plugins/http.js";

/**
 *
 * @param {string[]} includes
 */
function getIncludesQuery(includes, query = {}) {
    if (typeof query !== 'object') {
        query = {};
    }

    if (Array.isArray(includes) && includes.length) {
        query['includes'] = includes.join(',');
    }

    return query;
}

function getFiltersQuery(filters, query = {}) {
    if (typeof query !== 'object') {
        query = {};
    }

    if (Array.isArray(filters) && filters.length) {
        for (let index = 0; index < filters.length; index++) {
            query[`filters[${index}]`] = filters[index];
        }
    }

    return query;
}


function getQueryStrings(query = {}) {
    return new URLSearchParams(query).toString();
}

export function ApiResource(uri) {
    this.uri = uri;

    return {
        uri: this.uri,

        getList: (options = {query: {}, includes: [], filters: []}) => {
            const query = options?.query || {};

            const queryString = getQueryStrings({
                ...getIncludesQuery(options?.includes || []),
                ...getFiltersQuery(options?.filters || []),
                ...query,
            })

            return http.get(this.uri + '?' + queryString);
        },

        getById: (id, includes = []) => {
            const query = getQueryStrings(getIncludesQuery(includes));
            return http.get(`${this.uri}/${id}?${query}`);
        },

        create : (data) => {
            return http.post(this.uri, data);
        },

        update : (id, data) => {
            return http.put(`${this.uri}/${id}`, data);
        },

        delete : (id) => {
            return http.delete(`${this.uri}/${id}`);
        }
    }
}
