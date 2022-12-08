<template>
  <div class="bg-white w-full p-4 border rounded-xl shadow">
    <h4 class="font-bold text-xl mb-5">Login</h4>

    <div class="mb-2" v-if="errors.length > 0">
      <div class="mb-2 bg-red-100 border-red-600 text-red-600 font-bold text-sm border rounded-lg px-4 py-2" v-for="error in errors">
        {{error}}
      </div>
    </div>

    <label>
      <small>E-mail address</small><br>
      <input v-model="email" class="w-full py-1 px-4 border rounded-lg focus:shadow mb-3" type="email" placeholder="john@doe.com">
    </label>
    <br>
    <label>
      <small>Password</small><br>
      <input v-model="password" class="w-full py-1 px-4 border rounded-lg focus:shadow mb-5" type="password" placeholder="Password">
    </label>

    <div>
      <button @click="signIn" class="bg-teal-500 hover:bg-teal-700 py-1 px-4 rounded-lg shadow text-white text-sm font-bold uppercase">Log in</button>
    </div>
  </div>
</template>

<script>
  export default {
    name: "login",
    data() {
      return {
        email: null,
        password: null,
        errors: []
      }
    },
    methods: {
      signIn() {
        axios.post('/login', {
          email: this.email,
          password: this.password
        }).then(res => {
          if(res.data) {
            window.location.href = '/login';
          } else {
            this.errors.push('Your login information is incorrect.');
          }
        });
      }
    }
  }
</script>

<style scoped>

</style>