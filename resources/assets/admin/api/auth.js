export function callApiLogin(params) {
    return axios.post('/login', params)
        .then(response => response)
        .catch(error => error)
}

export function callApiLogout() {
    return axios.post('/logout')
        .then(response => response)
        .catch(error => error)
}
