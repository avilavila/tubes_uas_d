<template>
    <main>
        <v-container fluid fill-height class="bg">
            <v-layout flex align-center justify-center>
                <v-flex xs12 sm6 elevation-6>
                    <v-toolbar class="green darken-3">
                        <v-toolbar-title>
                            <h1>Register Page</h1>
                        </v-toolbar-title>
                    </v-toolbar>
                    <v-card>
                        <v-card-text class="pt-4">
                            <div>
                                <v-form v-model="valid" ref="form">
                                    <v-text-field label="Name" v-model="name" :rules="nameRules" required>
                                    </v-text-field>
                                    
                                    <v-text-field label="Username" v-model="username" :rules="usernameRules" required>
                                    </v-text-field>

                                    <v-text-field label="E-mail" v-model="email" :rules="emailRules" required>
                                    </v-text-field>

                                    <v-text-field label="Password" v-model="password" type="password"
                                        :rules="passwordRules" required>
                                    </v-text-field>

                                    <v-layout justify-center>
                                        <v-btn class="mr2" @click="submit" :class="{
                                            'green white--text': valid, disabled: !valid
                                        }">Register
                                        </v-btn>

                                        <v-btn @click="clear" class="grey darken-3 white--text">Clear</v-btn>
                                    </v-layout>
                                    
                                    <v-layout justify-center class="pt-3">
                                    <v-text class="black--text"
                                        >Already Have Account?
                                        <v-btn @click="register" text color="indigo accent-4">Login</v-btn>
                                    </v-text>
                                    </v-layout>
                                </v-form>
                            </div>
                        </v-card-text>
                    </v-card>
                    <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
                        {{ error_message }}
                    </v-snackbar>
                </v-flex>
            </v-layout>
        </v-container>
    </main>
</template>
  
<script>
export default {
    name: "RegisterPage",
    data() {
        return {
            load: false,
            snackbar: false,
            error_message: '',
            color: '',
            valid: false,
            name: "",
            nameRules: [(v) => !!v || "Nama Tidak boleh Kosong"],
            username: '',
            usernameRules: [(v) => !!v || "Username tidak boleh kosong"],
            password: '',
            passwordRules: [(v) => !!v || "Password tidak boleh kosong"],
            email: "",
            emailRules: [(v) => !!v || "E-mail tidak boleh kosong"],
        };
    },
    methods: {
        submit() {
            if (this.$refs.form.validate()) {
                this.load = true;
                this.$http
                    .post(this.$api + '/register', {
                        name: this.name,
                        username: this.username,
                        email: this.email,
                        password: this.password,
                    })
                    .then((response) => {
                        localStorage.setItem("id", response.data.user.id);
                        localStorage.setItem("token", response.data.access_token);
                        this.error_message = "Register Berhasil!";
                        this.color = "green";
                        this.snackbar = true;
                        this.load = false;
                        this.clear();
                        this.$router.push({
                        name: "LoginPage",
                        });
                    })
                    .catch((error) => {
                        this.error_message = error.response.data.message;
                        this.color = "red";
                        this.snackbar = true;
                        localStorage.removeItem("token");
                        this.load = false;
                    })
            }
        },
        register() {
            this.$router.push({
                name: "LoginPage",
            });
        },
        clear() {
            this.$refs.form.reset(); 
        },
    },
};
</script> 
  
<style>
.bg {
    background-image: url('https://wallpaperaccess.com/full/1624848.jpg');
    height: 100vh !important;
}
</style>