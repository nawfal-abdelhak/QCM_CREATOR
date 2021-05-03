<template>
  <div class="container">
    <!-- Jumbotron Header -->
    <header class="jumbotron my-4">
      <h1 class="display-3">Welcome!</h1>
      <p class="lead">Créer votre questionnaire en ligne, facile et gratuit</p>
      <router-link :to="{ name: 'example' }" class="btn btn-primary btn-lg">creer qcm</router-link>
    </header>

    <!-- Page Features -->
    <div class="row text-center">
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="http://placehold.it/500x325" alt />
          <div class="card-body">
            <h4 class="card-title">Card title</h4>
            <p
              class="card-text"
            >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="http://placehold.it/500x325" alt />
          <div class="card-body">
            <h4 class="card-title">Card title</h4>
            <p
              class="card-text"
            >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo magni sapiente, tempore debitis beatae culpa natus architecto.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="http://placehold.it/500x325" alt />
          <div class="card-body">
            <h4 class="card-title">Card title</h4>
            <p
              class="card-text"
            >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    Echo.channel("public").listen(
      "QuizCreated",
      ({ quiz }) => {
        console.log(quiz);
      }
    );
  },
  methods: {
    gotoo: function(event) {}
  }
};
</script>
