//env constants
const apiBaseUrl = location.origin + '/api/v1/';
const frontEndBase = location.origin + '/';

const roles = {
  'admin': 'Admin',
  'writer': 'Writer',
  'reader': 'Viewer',
};

const apiRouter = {
     'login' : apiBaseUrl + 'auth/login',
     'logout' : apiBaseUrl + 'auth/logout',
     'addNewUser' : apiBaseUrl + 'users',
     'getAllUser' : apiBaseUrl + 'users',
     'changeUserRole' : apiBaseUrl + 'users/changerole',
     'getAllPost' : apiBaseUrl + 'posts',
     'getPost' : apiBaseUrl + 'posts/',
     'addNewPost' : apiBaseUrl + 'posts',
     'addNewPostComment' : apiBaseUrl + 'posts/comment',
     'likePost' : apiBaseUrl + 'posts/{id}/like',
}

const webRouter = {
    'adminHomepage' : frontEndBase + 'home',
    'writerHomepage' : frontEndBase + 'writer',
    'viewerHomepage' : frontEndBase + 'reader',
    'loginPage' : frontEndBase + 'login',
    'users' : frontEndBase + 'users',
    'posts' : frontEndBase + 'posts',
}

const okStatus = [201,200,401];
