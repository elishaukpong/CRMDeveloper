function processLoginSuccess(data) {

    setCookie('token', data.access_token, data.expires_in);


    return redirect('/home');

}

function checkForAuth() {

}

function redirect(route) {
    window.location.href = route;
}

function setCookie(cname, cvalue, exseconds) {
    const d = new Date();
    d.setTime(d.getTime() + (exseconds*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function populateSelectFieldWithUsers(element) {
    getAllUsers(formatUsersForRoleChangeSelectElement,element);
}

function populateTableFieldWithUsers(element) {
    getAllUsers(formatUsersForDisplayUsersTableElement,element);
}

function formatUsersForRoleChangeSelectElement(data, element){

    element.append(
        data.reduce(function(cleanedData, currentData){
            return cleanedData += `<option value="${currentData.id}">${currentData.name}</option>`;
        },'')
    );
}

function formatUsersForDisplayUsersTableElement(data, element){

    element.append(
        data.reduce(function(cleanedData, currentData){
            return cleanedData += `<tr>
                                        <td>${currentData.name}</td>
                                        <td>${currentData.email}</td>
                                        <td>${currentData.roles[0].name}</td>
                                        <td>${currentData.created_at}</td>
                                    </tr>`;
        },'')
    );
}

function getAllUsers(handler,element){
    let requestOptions = {
        method: 'GET',
        headers: {
            'content-type': 'application/x-www-form-urlencoded',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + getCookie('token')
        }
    };

    fetch(getAllUser, requestOptions)
        .then(response => response.text())
        .then(result => JSON.parse(result))
        .then(result => handler(result.data, element))
        .catch(error => console.log('error', error));
}

function processUserRoleChange(elementId) {
    const formData = $(`form[id=${elementId}]`).serialize();

    let requestOptions = {
        method: 'POST',
        headers: {
            'content-type': 'application/x-www-form-urlencoded',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + getCookie('token')
        },
        body: formData
    };

    fetch(changeUserRole, requestOptions)
        .then(response => response.text())
        .then(result => console.log(result))
        .catch(error => console.log('error', error));
}

