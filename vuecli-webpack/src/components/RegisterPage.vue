<template>
    <main>
        <v-container fluid fill-height class="bg">
            <v-layout flex align-center justify-center>
                <v-flex xs12 sm6 elevation-6>
                    <v-toolbar class="orange darken-3">
                        <v-toolbar-title>
                            <h1>Register Page</h1>
                        </v-toolbar-title>
                    </v-toolbar>
                    <v-card>
                        <v-card-text class="pt-4">
                            <div>
                                <v-form v-model="valid" ref="form">
                                    <v-text-field label="Username" v-model="username" :rules="usernameRules" required>
                                    </v-text-field>

                                    <v-text-field label="E-mail" v-model="email" :rules="emailRules" required>
                                    </v-text-field>

                                    <v-text-field label="Password" v-model="password" type="password"
                                        :rules="passwordRules" required>
                                    </v-text-field>

                                    <v-layout>
                                        <v-btn class="mr-3 mt-3" @click="submit" :class="{
                                            'green white--text': valid, disabled: !valid
                                        }">Register
                                        </v-btn>

                                        <v-btn @click="home" class="blue darken-3 white--text mt-3">Back

                                        </v-btn>

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
    name: "RegisterMenu",
    data() {
        return {
            load: false,
            snackbar: false,
            error_message: '',
            color: '',
            valid: false,
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
                        username: this.username,
                        email: this.email,
                        password: this.password,
                        tgllahir: this.tgllahir,
                    })
                    .then((response) => {
                        this.error_message = response.data.message;
                        this.color = "green";
                        this.snackbar = true;
                        this.load = false;
                        this.clear();
                        this.$router.push({
                            name: "LoginMenu",
                        });
                    })
                    .catch((error) => {
                        this.error_message = error.response.data.message;
                        this.color = "red";
                        this.snackbar = true;
                        this.load = false;
                    })
            }
        },
        home() {
            this.$router.push({
                name: "HomeDashboard",
            });
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