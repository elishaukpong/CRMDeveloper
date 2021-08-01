//env constants
const apiBaseUrl = location.origin + '/api/v1/';
const frontEndBase = location.origin + '/';

let roles = {
  'admin': 'Admin',
  'writer': 'Writer',
  'reader': 'Viewer',
};

//web routes
const adminHomepage = frontEndBase + 'home';
const writerHomepage = frontEndBase + 'writer';
const viewerHomepage = frontEndBase + 'reader';
const loginPage = frontEndBase + 'login';

//api routes
const login = apiBaseUrl + 'auth/login';
const logout = apiBaseUrl + 'auth/logout';
const addNewUser = apiBaseUrl + 'users';
const getAllUser = apiBaseUrl + 'users';
const changeUserRole = apiBaseUrl + 'users/changerole';
const getAllPost = apiBaseUrl + 'posts';
const getPost = apiBaseUrl + 'posts/';
const addNewPost = apiBaseUrl + 'posts';
const addNewPostComment = apiBaseUrl + 'posts/comment';
const likePost = apiBaseUrl + 'posts/{id}/like';
