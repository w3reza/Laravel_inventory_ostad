function showLoader() {
    document.getElementById('loader').classList.remove('d-none')
}
function hideLoader() {
    document.getElementById('loader').classList.add('d-none')
}

function successToast(msg) {
    Toastify({
        gravity: "bottom", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        text: msg,
        className: "mb-5",
        style: {
            background: "green",
        }
    }).showToast();
}

function errorToast(msg) {
    Toastify({
        gravity: "bottom", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        text: msg,
        className: "mb-5",
        style: {
            background: "red",
        }
    }).showToast();
}


function unauthorized(code){
    if(code===401){
        localStorage.clear();
        sessionStorage.clear();
        window.location.href="/logout"
    }
}

function setToken(token) {
    document.cookie = `token=Bearer ${token}; path=/;`;
}

function getToken() {
    const cookies = document.cookie.split(';');
    for (const cookie of cookies) {
        const [name, value] = cookie.trim().split('=');
        if (name === 'token') {
            return value;
        }
    }
    return null;
}

function HeaderToken() {
    const token = getToken();
    return {
        headers: {
            Authorization: token
        }
    };
}

function removeCookie() {
    document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

function cookieExists() {
    return document.cookie.split(';').some((cookie) => cookie.trim().startsWith('token='));
}





