
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

function unsetCookie(cname) {
    document.cookie = cname + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
}

function getPostId() {
    return window.location.pathname.split('/').filter(data => data)[1];
}


function redirect(route) {
    window.location.href = route;
}

function getAuthTypeRedirectRoute(type){
    switch (type) {
        case 'Admin':
            return webRouter.adminHomepage;

        case 'Writer':
            return webRouter.writerHomepage;

        default:
            return webRouter.viewerHomepage;
    }
}


function recordSuccess(message) {
    displayToastMessage(message,'alerts','primary');
}

function errorHandler(message) {
    displayToastMessage(message,'alerts','danger');
}

function displayToastMessage(message,elementId,alertclass){
    $(`#${elementId}`).append(`<div class="col-8 mx-auto">
                    <div class="alert alert-${alertclass}" role="alert">
                        ${message}
                    </div>
                </div>`);

    setTimeout(function(){
        $(`#${elementId}`).empty();
    },2000);
}


function checkForAuth() {

    token = getCookie('token');

    if( !token ){
        redirect(webRouter.loginPage)
    }

}

function checkAuthFor(role){
    if(! checkForRole(role)){
        checkForNoAuth();
    }
}

function checkForNoAuth() {

    let token = getCookie('token');

    if( token ){
        return redirect(getAuthTypeRedirectRoute(getCookie('role')));
    }

}

function checkForRole(role) {
    return role === getCookie('role');
}


function makeRequestWithBody(requestVerb,requestUrl, data, successHandler){
    let requestOptions = {
        method: requestVerb,
        headers: {
            'content-type': 'application/x-www-form-urlencoded',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + getCookie('token')
        },
        body: data
    };

    fetch(requestUrl, requestOptions)
        .then((response) => {
            if (okStatus.includes(response.status)) {
                return Promise.resolve(response.json());
            }
            return Promise.resolve(response.json())
                .then((responseInJson) => {
                    return Promise.reject(responseInJson.message);
                });
        })
        .then(result => successHandler(result))
        .catch(error => errorHandler(error));
}

function makeRequestWithoutBody(requestVerb,requestUrl,successHandler,element){
    let requestOptions = {
        method: requestVerb,
        headers: {
            'content-type': 'application/x-www-form-urlencoded',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + getCookie('token')
        },
    };

    fetch(requestUrl, requestOptions)
        .then((response) => {
            if (okStatus.includes(response.status)) {
                return Promise.resolve(response.json());
            }
            return Promise.resolve(response.json())
                .then((responseInJson) => {
                    return Promise.reject(responseInJson.message);
                });
        })
        .then(result => successHandler(result,element))
        .catch(error => errorHandler(error));
}


function loginUser(formElementId){
    makeRequestWithBody('POST', apiRouter.login, $(`form[id=${formElementId}]`).serialize(), processLoginSuccess);
}

function processLoginSuccess(data) {
    setCookie('token', data.access_token, data.expires_in);
    setCookie('auth_id', data.user[0].id, data.expires_in);
    setCookie('role', data.user[0].roles[0].name, data.expires_in);

    return redirect(getAuthTypeRedirectRoute(data.user[0].roles[0].name));
}

function logoutUser() {
    makeRequestWithoutBody('POST',apiRouter.logout,processLogoutSuccess,'')
}

function processLogoutSuccess(data,element){
    unsetCookie('token');
    unsetCookie('auth_id');
    unsetCookie('role');

    return redirect(webRouter.loginPage);
}

function populateSelectFieldWithUsers(element) {
    makeRequestWithoutBody('GET',apiRouter.getAllUser,formatUsersForRoleChangeSelectElement,element);
}

function formatUsersForRoleChangeSelectElement(result, element){
    element.append(
        result.data.reduce(function(cleanedData, currentData){
            return cleanedData += `<option value="${currentData.id}">${currentData.name}</option>`;
        },'')
    );
}

function populateTableFieldWithUsers(element) {
    makeRequestWithoutBody('GET',apiRouter.getAllUser,formatUsersForDisplayUsersTableElement,element);
}

function formatUsersForDisplayUsersTableElement(result, element){
    element.append(
        result.data.reduce(function(cleanedData, currentData){
            return cleanedData += `<tr>
                                        <td>${currentData.name}</td>
                                        <td>${currentData.email}</td>
                                        <td>${currentData.roles[0].name}</td>
                                        <td>${currentData.created_at}</td>
                                    </tr>`;
        },'')
    );
}

function processUserRoleChange(elementId) {
    makeRequestWithBody('POST', apiRouter.changeUserRole, $(`form[id=${elementId}]`).serialize(), handleUserRoleChangeSuccess);
}

function handleUserRoleChangeSuccess(result){
    return redirect(webRouter.users);
}

function createNewUser(formElementId) {
    makeRequestWithBody('POST', apiRouter.addNewUser, $(`form[id=${formElementId}]`).serialize(), handleUserRegistrationSuccess);
}

function handleUserRegistrationSuccess(result){
    return redirect(webRouter.users);
}

function createNewPost(formElementId) {
    makeRequestWithBody('POST', apiRouter.addNewPost, $(`form[id=${formElementId}]`).serialize(), handlePostCreationSuccess);
}

function handlePostCreationSuccess(result){
    return redirect(webRouter.posts);
}

function populateTableFieldWithPosts(element){
    makeRequestWithoutBody('GET',apiRouter.getAllPost,formatPostsForPostTableElement,element);
}

function formatPostsForPostTableElement(result,element) {
    element.append(
        result.data.reduce(function(cleanedData, currentData){
            return cleanedData += `<tr>
                                        <td>${currentData.title}</td>
                                        <td>${currentData.creator.name}</td>
                                        <td>${currentData.created_at}</td>
                                        <td>${currentData.likes}</td>
                                        <td>${currentData.views}</td>
                                        <td><a href="/posts/${currentData.id}" class="btn btn-dark form-control">View</a></td>
                                    </tr>`;
        },'')
    );
}

function loadPost(element){
    makeRequestWithoutBody('GET',apiRouter.getPost + getPostId(), handleLoadPostSuccess, element);
}

function handleLoadPostSuccess(result, element) {
    let data = result.data[0];

    let previousComment = data.comments.reduce(function(cleanedData, currentData){
        return cleanedData += `<li>${currentData.message} - ${currentData.commentator.name}</li>`;
    },'');

    let content = `
                    <h1 class="mb-4">${data.title}</h1>
                    <p>${data.content}</p>

                    <button class="btn btn-dark" id="like">Like</button> <br><br>

                    <form class="mt-5" id="comment">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Add Comment</label>
                            <textarea class="form-control" name="message" id="textarea" rows="3" required></textarea>
                        </div>

                        <input name='user_id' hidden value="${getCookie('auth_id')}">
                        <input name='post_id' hidden value="${getPostId()}">

                        <button class="btn btn-primary btn-sm" type="submit">Comment</button>
                    </form>

                    <ul class="mt-5" id="previous-comment">
                        <p>Previous Comments</p>
                        ${previousComment}
                    </ul>
                `;

    element.append(content);
}

function createNewPostComment(formElementId){
    makeRequestWithBody('POST', apiRouter.addNewPostComment, $(`form[id=${formElementId}]`).serialize(), handlePostCommentCreationSuccess);
}

function handlePostCommentCreationSuccess(result){
    recordSuccess(result.message);
    $('#previous-comment').append(`<li>${result.data[0].message} - ${result.data[0].commentator.name}</li>`);
}

function likeUserPost(){
    let likePostUrl = apiRouter.likePost.replace('{id}', getPostId());
    makeRequestWithoutBody('GET',likePostUrl,handlePostLikeSuccess,'')
}

function handlePostLikeSuccess(result,element){
    recordSuccess('Post Liked!')
}


