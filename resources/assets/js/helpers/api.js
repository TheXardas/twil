import fetch from "isomorphic-fetch"

export function get(url) {
    return makeRequest('get', url)
}

export function post(url, data) {
    // todo implement
}

function makeRequest(method, url) {
    url = url.replace(/\/+$/, '').replace(/^\/+/, '');

    return fetch('/api/' + url, {
        method: method
    }).then(onRequestComplete);
    // todo global error handler
}

function onRequestComplete(response) {
    if (response.status >= 200 && response.status < 300) {
        return response.json()
    } else {
        return Promise.reject(new Error(response.statusText))
    }
}