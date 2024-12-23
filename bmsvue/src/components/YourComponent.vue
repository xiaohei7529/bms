<template>
    <div>
        <h1>Your Component</h1>
        <button @click="login"> 登录</button>
        <button @click="logout"> 退出</button>
        <button @click="profile"> 123123132123</button>
    </div>
</template>

<script>

export default {
    name: 'ExampleComponent',
    data() {
        return {
            userData: null,
            email:'admin1@163.com',
            password:'123456'
        };
    },
    created() {
        // this.getUserData();
    },
    methods: {
        async getUserData() {
            try {
                const data = await this.$http.get('/user');
                this.userData = data;
            } catch (error) {
                console.error('Error fetching user data:', error);
            }
        },

        login() {
            this.$http.post('/api/login', { email: this.email, password: this.password })
                .then((response) => {
                    localStorage.setItem('token', response.access_token); // 存储 Token
                    console.log('Login successful!');
                    this.$notify({
                        title: '成功',
                        message: '登录成功！',
                        type: 'success'
                    });
                })
                .catch((error) => {
                    console.error('Login failed:', error);
                });
        },
        logout() {
            localStorage.removeItem('token');
            console.log('Logged out!');
            this.$notify({
                title: '成功',
                message: '退出成功！',
                type: 'success'
            });
        },
        profile() {
            this.$http.get('/api/profile')
                .then((response) => {
                    console.log(response);
                    // localStorage.setItem('token', response.access_token); // 存储 Token
                    console.log('Login successful!');
                    this.$notify({
                        title: '成功',
                        message: '获取数据成功！',
                        type: 'success'
                    });
                })
                .catch((error) => {
                    console.error('Login failed:', error);
                });
        }

    },
};


</script>