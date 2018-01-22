export function callFetchMenus(params = {}) {
    return axios.get('/menus', params)
        .then(response => response)
        .catch(error => error)
}

// export function callApiLogout() {
//     return axios.post('/logout')
//         .then(response => response)
//         .catch(error => error)
// }
