<template>
  <div class="row">
    <div class="col-12">
      <div
        style="font-size: 1.5em; background: #e1f8ff; padding: 5px 10px; min-height: 40px;"
      >Dans cette page, vous pouvez créer le contenu de votre questionnaire : titre, questions, etc.</div>
    </div>

    <div class="col-12 mt-3">
       <label for="quizTitle" style="font-size: 1.5em">Titre de votre questionnaire</label>
      <div class="row">
       
        <div class=" col-9">
          <input
            type="text"
            class="form-control "
            v-model="quizTitle"
            id="quizTitle"
            placeholder="Titre du questionnaire"
          />
        </div>
      
      <div class="col-1">
        <input v-model="timer" type="number" class="form-control " placeholder="dureé" />
      </div>
      <div class="col-1">
        <input v-model="group" type="text" class="form-control" placeholder="groupe" />
      </div>
      </div>
    </div>

    <div class="col-12 mt-3" v-for="(question, questionIndex) in questions" :key="questionIndex">
      <div class="row col-12 qst-title">Question {{questionIndex + 1}}</div>
      <div class="row">
        <div class="col-12 justify-content-center d-flex">
          <div class="input-group col-6">
            <div class="input-group-prepend"></div>
          </div>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-9">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="yourQuestion">Votre question</label>
            </div>
            <input
              type="text"
              class="form-control"
              placeholder="Question"
              aria-label="Question"
              id="yourQuestion"
              v-model="question.text"
            />
          </div>
        </div>
      </div>

      

            <strong>Image:</strong>
            <input  type="file" class="form-control col-9" style="margin-bottom:6px;padding-bottom:37px;" v-on:change="onImageChange" />

            
          <button style="margin-bottom:3px;" @click="formSubmit(question)" class="btn btn-success">envoyer</button>
      <div><img v-if="question.realPath" width="400" height="200" v-bind:src=" question.realPath"></div>
      

      <div class="row">
        <div
          class="col-12 mt-2"
          v-for="(choice, choiceIndex) in question.choices"
          :key="choiceIndex"
        >
          <div class="row col-12 qst-title mb-1">Réponse {{choiceIndex + 1}}</div>
          <div class="row">
            <div class="col-9">
              <input v-model="choice.text" type="text" class="form-control" placeholder="Réponse" />
            </div>
            <div class="col-1">
              <input type="checkbox" class="form-control" v-model="choice.isCorrect" />
            </div>
            <div class="col-1">
              <input v-model="choice.point" type="number" class="form-control" />
            </div>
            <div class="col-1 d-flex">
              <button
                @click="remove(question,choiceIndex)"
                type="button"
                class="btn btn-danger btn-sm"
              >Supprimer</button>
            </div>
          </div>
        </div>
      </div>

      <div class="row col-12 mt-3">
        <button class="btn btn-success" @click="addChoice(question)"> Nouveaux choix</button>
      </div>
      <hr style=" border-top: 1px solid blue;" />
    </div>
    <div class="col-12">
      <button class="btn btn-success mr-3" @click="addQuestion()">Nouvelle question</button>
      <button class="btn btn-primary" @click="submit()">Envoyer</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: true,
      image: "",
      success: "",
      name: null,
      timer: null,
      quizTitle: "",
      group: "",

      questions: [
        {
          text: "",

          choices: [
            {
              text: "",
              isCorrect: false,
              point: 0
            }
          ]
        }
      ]
    };
  },
  mounted() {},
  methods: {
    onImageChange(e) {
      console.log(e.target.files[0]);
      this.image = e.target.files[0];
    },
    formSubmit(question) {
      console.log(question);
      this.show = false;
      let currentObj = this;

      const config = {
        headers: { "content-type": "multipart/form-data" }
      };

      let formData = new FormData();
      formData.append("image", this.image);
      formData.append("questionId", question.id);

      axios
        .post("formSubmit", formData, config)
        .then(({ data }) => {
          console.log(data);
          question.realPath = data.realPath;
          question.image = data.image;
          this.$forceUpdate();
        })
        .catch(function(error) {
          currentObj.output = error;
        });
    },

    addQuestion() {
      this.show = true;
      this.questions.push({
        text: "",

        choices: [
          {
            text: "",

            point: 0,
            isCorrect: false
          }
        ]
      });
    },
    addChoice(question) {
      question.choices.push({
        text: "",
        isCorrect: false,
        point: 0
      });
    },
    submit() {
      axios
        .post("createQuiz", {
          timer: this.timer,
          quizTitle: this.quizTitle,
          questions: this.questions,
          group: this.group
        })
        .then(({ data }) => {
          console.log(data);
          this.reset();
        })
        .catch(error => {
          console.error(error);
        })
        .then(() => {});
    },
    reset() {
      this.questions = [
        {
          text: "",

          choices: [
            {
              text: "",
              isCorrect: false,
              point: 0
            }
          ]
        }
      ];
      this.quizTitle = "";
      this.group = "";
      this.timer = null;
    },
    remove(question, index) {
      console.log(index);
      console.log(question);
      question.choices.splice(index, 1);
    }
  }
};
</script>

<style scoped>
.qst-title {
  font-weight: bold;
  color: #0070c0;
  font-size: 1.5em;
}
</style>
