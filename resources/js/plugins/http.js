import axios from 'axios'

export const BASE_URL = '/api';

const http = axios.create({withCredentials: true});
http.defaults.withCredentials = true;

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

function getCsrfToken() {
    let token;
    try {
        token = getCookie('XSRF-TOKEN');
    } catch (e) {
        console.log(e)
    }

    if (!token) {
        token = document.head.querySelector('meta[name="csrf-token"]');
    }
    return token;
}

http.interceptors.request.use((config) => {
    const csrfToken = getCsrfToken();
    if (csrfToken) {
        config.headers['X-CSRF-TOKEN'] = csrfToken.content;
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }

    const authToken = localStorage.getItem('token');
    if (authToken) {
        config.headers['Authorization'] = `Bearer ${authToken}`
    }

    config.headers['X-Requested-With'] = 'XMLHttpRequest';
    config.withCredentials = true;
    config.baseURL = BASE_URL;
    return config;
});

http.defaults.headers.common['Content-type'] = 'application/json';

export default http;
