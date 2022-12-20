<template>
    <main>
        <v-container fluid fill-height class="bg">
            <v-layout flex align-center justify-center>
                <v-flex xs12 sm6 elevation-6>
                    <v-toolbar class="green darken-3">
                        <v-toolbar-title>
                            <h1>Login Page</h1>
                        </v-toolbar-title>
                    </v-toolbar>

                    <v-card>
                        <v-card-text class="pt-4">
                            <div>
                                <v-form v-model="valid" ref="form">
                                    <v-text-field label="E-mail" v-model="email" :rules="emailRules" required></v-text-field>
                                    <v-text-field label="Password" v-model="password" type="password" min="8" :rules="passwordRules" counter required></v-text-field>
                                   
                                        <v-layout justify-center>
                                            <v-btn class="mr-3 mt-5" @click="submit" :class="{ 'black darken-1 green--text': valid, disabled: !valid }">Login</v-btn>
                                            <v-btn @click="clear" class="grey darken-3 white--text mt-5">Clear</v-btn>
                                        </v-layout>
                                            <v-layout justify-center class="pt-3 mt-5">
                                            <v-text>Dont have any account? <v-btn @click="register" text color="indigo accent-4">Register</v-btn></v-text>
                                        </v-layout>
                                </v-form>
                            </div>
                        </v-card-text>
                    </v-card>
                    <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
                        {{ error_message }}
                    </v-snackbar>
                    <v-snackbar v-model="success" color="green" timeout="2000" bottom>
                        Verifikasi Email Sukses
                    </v-snackbar>
                </v-flex>
            </v-layout>
        </v-container>
    </main>
</template>
  
  
<script>
export default {
    name: "LoginPage",
    components: {
    },
    data() {
        return {
            load: false,
            snackbar: false,
            error_message: "",
            color: "",
            valid: false,
            email: "",
            emailRules: [(v) => !!v || "E-mail tidak boleh kosong"],
            password: "",
            passwordRules: [(v) => !!v || "Password tidak boleh kosong "],
        };
    },
    methods: {
        submit() {
            if (this.$refs.form.validate()) {
                this.load = true;
                this.$http.post(this.$api + "/login", {
                        email: this.email,
                        password: this.password,
                    })
                    .then((response) => {
                        localStorage.setItem("id", response.data.user.id);
                        localStorage.setItem("token", response.data.access_token);
                        this.error_message = "Login Berhasil!";
                        this.color = "green";
                        this.snackbar = true;
                        this.load = false;
                        if(this.email == "admin@gmail.com" && this.password == "admin"){
                            this.clear();
                            this.$router.push({
                                name: "DashboardIndexAdmin",
                            });
                        } else {
                            this.clear();
                            this.$router.push({
                                name: "DashboardIndex",
                            });
                        }
                        
                        
                        
                    })
                    .catch((error) => {
                        this.error_message = error.response.data.message;
                        this.color = "red";
                        this.snackbar = true;
                        localStorage.removeItem("token");
                        this.load = false;
                    });
            }
        },
        register() {
            this.$router.push({
                name: "RegisterPage",
            });
        },
        showVerified() {
            if (this.$route.query.verified == "success") {
                this.success = true;
                this.$router.push("/login");
            }
        },
        clear() {
            this.$refs.form.reset(); // clear form login
        },
        mounted() {
            this.showVerified();
        },
    }
};
</script> 

<style>
.bg {
    background-image: url('https://wallpaperaccess.com/full/1624848.jpg');
    height: 100vh !important;
}
</style>