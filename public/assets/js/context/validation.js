class auth {
  
    constructor(UserEmail) {
        this.UserEmail = UserEmail;
    }

    logout() {
        let xhr, get_init, obj, userDetailsToken;
        xhr = new XMLHttpRequest();
        xhr.open('POST', root_base+ 'AuthController/logout');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                get_init = xhr.response;
                obj = JSON.parse(get_init).data;    
                if (obj.status == 200) {
                    window.location.replace(root_base+'auth/login/');  
                }
            return false;
            }
        }
    xhr.send();
  }

  
}

// Export the class, so it can be imported in other files
export default auth;