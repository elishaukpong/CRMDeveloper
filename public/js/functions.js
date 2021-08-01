function loginUser(formElementId){
    makeRequestWithBody('POST', login, $(`form[id=${formElementId}]`).serialize(), processLoginSuccess);
}

function processLoginSuccess(data) {
    setCookie('token', data.access_token, data.expires_in);
    setCookie('auth_id', data.user[0].id, data.expires_in);
    setCookie('role', data.user[0].roles[0].name, data.expires_in);

    return redirect(getAuthTypeRedirectRoute(data.user[0].roles[0].name));
}

function logoutUser() {
    makeRequestWithoutBody('POST',logout,processLogoutSuccess,'')
}

function processLogoutSuccess(data,element){
    unsetCookie('token');
    unsetCookie('auth_id');
    unsetCookie('role');

    return redirect(loginPage);
}

function getAuthTypeRedirectRoute(type){
    switch (type) {
        case 'Admin':
            return adminHomepage;

        case 'Writer':
            return writerHomepage;

        default:
            return viewerHomepage;
    }
}

function checkForAuth() {

    token = getCookie('token');

    if( !token ){
        redirect(loginPage)
    }

}

function checkForAdmin(){
    if(! checkForRole(roles.admin)){
        checkForNoAuth();
    }
}

function checkForWriter(){
    if(! checkForRole(roles.writer)){
        checkForNoAuth();
    }
}

function checkForReader(){
    if(! checkForRole(roles.reader)){
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

function unsetCookie(cname) {
    document.cookie = cname + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
}

function populateSelectFieldWithUsers(element) {
    makeRequestWithoutBody('GET',getAllUser,formatUsersForRoleChangeSelectElement,element);
}

function formatUsersForRoleChangeSelectElement(data, element){
    element.append(
        data.reduce(function(cleanedData, currentData){
            return cleanedData += `<option value="${currentData.id}">${currentData.name}</option>`;
        },'')
    );
}

function populateTableFieldWithUsers(element) {
    makeRequestWithoutBody('GET',getAllUser,formatUsersForDisplayUsersTableElement,element);
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

function processUserRoleChange(elementId) {
    makeRequestWithBody('POST', changeUserRole, $(`form[id=${elementId}]`).serialize(), handleUserRoleChangeSuccess);
}

function createNewUser(formElementId) {
    makeRequestWithBody('POST', addNewUser, $(`form[id=${formElementId}]`).serialize(), handleUserRegistrationSuccess);
}

function handleUserRegistrationSuccess(result){
    return redirect('/users');
}

function createNewPost(formElementId) {
    makeRequestWithBody('POST', addNewPost, $(`form[id=${formElementId}]`).serialize(), handlePostCreationSuccess);
}

function handlePostCreationSuccess(result){
    return redirect('/posts');
}

function handleUserRoleChangeSuccess(result){
    return redirect('/users');
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
        .then(response => response.text())
        .then(result => JSON.parse(result))
        .then(result => successHandler(result))
        .catch(error => console.log('error', error));
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
        .then(response => response.text())
        .then(result => JSON.parse(result))
        .then(result => successHandler(result.data,element))
        .catch(error => console.log(error));
}

function populateTableFieldWithPosts(element){
    makeRequestWithoutBody('GET',getAllPost,formatPostsForPostTableElement,element);
}

function formatPostsForPostTableElement(data,element) {
    element.append(
        data.reduce(function(cleanedData, currentData){
            return cleanedData += `<tr>
                                        <td>${currentData.title}</td>
                                        <td>${currentData.creator.name}</td>
                                        <td>${currentData.created_at}</td>
                                        <td><a href="/posts/${currentData.id}" class="btn btn-dark form-control">View</a></td>
                                    </tr>`;
        },'')
    );
}

function getPostId() {
    return window.location.pathname[window.location.pathname.length-1];
}

function loadPost(element){
    makeRequestWithoutBody('GET',getPost + getPostId(), handleLoadPostSuccess, element);
}

function handleLoadPostSuccess(data, element) {
    data = data[0];

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
    makeRequestWithBody('POST', addNewPostComment, $(`form[id=${formElementId}]`).serialize(), handlePostCommentCreationSuccess);
}

function handlePostCommentCreationSuccess(result){
    recordSuccess(result.message);
    $('#previous-comment').append(`<li>${result.data[0].message} - ${result.data[0].commentator.name}</li>`);
}

function likeUserPost(){
    let likePostUrl = likePost.replace('{id}', getPostId());
    makeRequestWithoutBody('GET',likePostUrl,handlePostLikeSuccess,'')
}

function handlePostLikeSuccess(result,element){
    recordSuccess('Post Liked!')
}

function recordSuccess(message) {

    $('#alerts').append(`<div class="col-8 mx-auto">
                    <div class="alert alert-primary" role="alert">
                        ${message}
                    </div>
                </div>`);

    setTimeout(function(){
        $('#alerts').empty();
    },2000);
}
