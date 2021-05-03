<template>
  <div class="row">
    <div class="row" style="margin-bottom:20px;">
      <div class="col-lg-3 col-md-6" v-for="quiz in quizzes" :key="quiz.id" style="margin-bottom:3px">
        <div v-if="show1" class="card pp">
          <div class="card-body">
            <h3>{{quiz.title}}</h3>
            <h5>{{quiz.created_at}}</h5>
            
            <div class="row">
              <svg
              title="supprimez qcm"
                class="bi bi-trash-fill col-4"
                width="1.2em"
                height="1.2em"
                viewBox="0 0 16 16"
                fill="currentColor"
                xmlns="http://www.w3.org/2000/svg"
                @click="deleteQuiz(quiz.id)"
                style="cursor:pointer;color:red"
              >
                <path
                  fill-rule="evenodd"
                  d="M2.5 1a1 1 0 00-1 1v1a1 1 0 001 1H3v9a2 2 0 002 2h6a2 2 0 002-2V4h.5a1 1 0 001-1V2a1 1 0 00-1-1H10a1 1 0 00-1-1H7a1 1 0 00-1 1H2.5zm3 4a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7a.5.5 0 01.5-.5zM8 5a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7A.5.5 0 018 5zm3 .5a.5.5 0 00-1 0v7a.5.5 0 001 0v-7z"
                  clip-rule="evenodd"
                />
              </svg>


              <!-- <svg v-if="!quiz.deleted" @click="uncallQuiz(quiz.id)" style="cursor:pointer;color:dark"   class="bi bi-file-earmark-arrow-up col-4" width="1.2em" height="1.2em"  viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 1h5v1H4a1 1 0 00-1 1v10a1 1 0 001 1h8a1 1 0 001-1V6h1v7a2 2 0 01-2 2H4a2 2 0 01-2-2V3a2 2 0 012-2z"/>
              <path d="M9 4.5V1l5 5h-3.5A1.5 1.5 0 019 4.5z"/>
              <path fill-rule="evenodd" d="M5.646 8.854a.5.5 0 00.708 0L8 7.207l1.646 1.647a.5.5 0 00.708-.708l-2-2a.5.5 0 00-.708 0l-2 2a.5.5 0 000 .708z" clip-rule="evenodd"/>
              <path fill-rule="evenodd" d="M8 12a.5.5 0 00.5-.5v-4a.5.5 0 00-1 0v4a.5.5 0 00.5.5z" clip-rule="evenodd"/>
              </svg> -->



              <svg v-if="!quiz.deleted" @click="uncallQuiz(quiz.id)" style="cursor:pointer;" class="bi bi-eye-slash col-4" width="1.2em" height="1.2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 00-2.79.588l.77.771A5.944 5.944 0 018 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0114.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
              <path d="M11.297 9.176a3.5 3.5 0 00-4.474-4.474l.823.823a2.5 2.5 0 012.829 2.829l.822.822zm-2.943 1.299l.822.822a3.5 3.5 0 01-4.474-4.474l.823.823a2.5 2.5 0 002.829 2.829z"/>
              <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 001.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 018 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709z"/>
              <path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z" clip-rule="evenodd"/>
              </svg>


              <svg style="cursor:pointer"  v-if="quiz.deleted"
                @click="callQuiz(quiz.id,quiz.group)" class="bi bi-eye col-4" width="1.2em" height="1.2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 001.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0014.828 8a13.133 13.133 0 00-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 001.172 8z" clip-rule="evenodd"/>
              <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5zM4.5 8a3.5 3.5 0 117 0 3.5 3.5 0 01-7 0z" clip-rule="evenodd"/>
             </svg>
             
              <!-- <svg
             
                style="cursor:pointer;color:blue"
                @click="callQuiz(quiz.id,quiz.group)"
                v-if="quiz.deleted"
                class="bi bi-file-earmark-arrow-down col-4"
                width="1.2em"
                height="1.2em"
                viewBox="0 0 16 16"
                fill="currentColor"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M4 1h5v1H4a1 1 0 00-1 1v10a1 1 0 001 1h8a1 1 0 001-1V6h1v7a2 2 0 01-2 2H4a2 2 0 01-2-2V3a2 2 0 012-2z"
                />
                <path d="M9 4.5V1l5 5h-3.5A1.5 1.5 0 019 4.5z" />
                <path
                  fill-rule="evenodd"
                  d="M5.646 9.146a.5.5 0 01.708 0L8 10.793l1.646-1.647a.5.5 0 01.708.708l-2 2a.5.5 0 01-.708 0l-2-2a.5.5 0 010-.708z"
                  clip-rule="evenodd"
                />
                <path
                  fill-rule="evenodd"
                  d="M8 6a.5.5 0 01.5.5v4a.5.5 0 01-1 0v-4A.5.5 0 018 6z"
                  clip-rule="evenodd"
                />
              </svg> -->

             

              <svg
              @click="onQuizClick(quiz)"
               style="cursor:pointer;color:green"
                class="bi bi-book col-4"
                width="1.2em"
                height="1.2em"
                viewBox="0 0 16 16"
                fill="currentColor"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M3.214 1.072C4.813.752 6.916.71 8.354 2.146A.5.5 0 018.5 2.5v11a.5.5 0 01-.854.354c-.843-.844-2.115-1.059-3.47-.92-1.344.14-2.66.617-3.452 1.013A.5.5 0 010 13.5v-11a.5.5 0 01.276-.447L.5 2.5l-.224-.447.002-.001.004-.002.013-.006a5.017 5.017 0 01.22-.103 12.958 12.958 0 012.7-.869zM1 2.82v9.908c.846-.343 1.944-.672 3.074-.788 1.143-.118 2.387-.023 3.426.56V2.718c-1.063-.929-2.631-.956-4.09-.664A11.958 11.958 0 001 2.82z"
                  clip-rule="evenodd"
                />
                <path
                  fill-rule="evenodd"
                  d="M12.786 1.072C11.188.752 9.084.71 7.646 2.146A.5.5 0 007.5 2.5v11a.5.5 0 00.854.354c.843-.844 2.115-1.059 3.47-.92 1.344.14 2.66.617 3.452 1.013A.5.5 0 0016 13.5v-11a.5.5 0 00-.276-.447L15.5 2.5l.224-.447-.002-.001-.004-.002-.013-.006-.047-.023a12.582 12.582 0 00-.799-.34 12.96 12.96 0 00-2.073-.609zM15 2.82v9.908c-.846-.343-1.944-.672-3.074-.788-1.143-.118-2.387-.023-3.426.56V2.718c1.063-.929 2.631-.956 4.09-.664A11.956 11.956 0 0115 2.82z"
                  clip-rule="evenodd"
                />
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="!show1" class="all">
      <div class="titre1">Qcm Choisis :</div>
      <div class="titre2">{{quiz}}</div>
    </div>

  

    <div class="col-12" style="margin-top:70px;" v-if="show2">
      <div class="row">
        <div class="col-lg-3 col-md-6 " v-for="user in quizUsers" :key="user.id">
          <div class="card pp" style="margin-top:4px ;cursor:pointer"  @click="onQuizUserClick(user.quiz.questions,user.user.name)">
            <div class="card-body" >
              <h4 class="card-title">{{user.user.name}}</h4>
              <p class="card-text">{{user.user.group}}</p>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div v-if="show22" class="all2">
      <div class="titre1">Etudiant choisis :</div>
      <div class="titre2">{{student}}</div>
    </div>

    <button v-if="but" type="button" class="btn btn-dark butt" @click="butt()">clicker ici pour revenir un pas</button>

    <div v-if="show3" class="col-12" style="margin-top:160px;">
      <div v-for="(question, questionIndex) in questions" :key="'question'+question.id">
        <div style="font-weight: bold;color: #0070C0;font-size: 1.5em">Question {{questionIndex + 1}}</div>
        <img v-if="question.image"  width="400" height="200" v-bind:src=" question.image" />
        <div style="font-weight: bold;color: #0070C0;font-size: 1.5em">{{ question.text }}</div>
        <div style="margin-top:6px;" class="col-12" v-for="choice in question.choices" :key="'choice'+choice.id">
          <div class="row">
            <div
              class="col-6"
              v-bind:class="{ ss: choice.is_correct &&  choice.is_chosen ,gg:choice.is_correct && !choice.is_chosen  ,rr: !choice.is_correct  && choice.is_chosen }"
            >{{ choice.text }}</div>

            <div class="col-2">Chosen: {{ choice.is_chosen }}</div>
            <div class="col-2">Correct: {{ choice.is_correct }}</div>
            <div class="col-2">Point: {{ choice.point }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12" style="font-size:20px;margin-top:8px;" v-if="ss"> la note est : {{counterr}}/20</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show22: false,
      ss: false,
      show2: true,
      show1: true,
      show3: true,
      counterr: 0,
      change: false,
      quizzes: [],
      questions: [],
      quizUsers: [],
      answers: [],
      quiz: null,
      student: null,
      but: null
    };
  },
  created() {
    this.fetchMyQuizzes();
  },
 mounted() {
    Echo.channel("QuizUser")
      .listen("QcmAnswered", ({  }) => {
        
       this.fetchMyQuizzes();
        // this.quizzes.push(quiz);
      })
      .listen("AnotherEvent", ({ data }) => {
        console.log(data);
      });
    if (this.$route.params.quizId)
      console.log("quizId", this.$route.params.quizId);
  },

  methods: {
    fetchMyQuizzes() {
      axios
        .get("fetchMyQuizzes")
        .then(({ data }) => {
          console.log(data);
          this.quizzes = data;
        })
        .catch(error => {
          console.error(error);
        })
        .then(() => {
          // this.fetching = false;
        });
    },

    callQuiz(quizId,group) {
      console.log(quizId);
      console.log(group);
      axios

        .post("callQuiz", {
          quizId: quizId,
          group:group,
        })
        .then(({ data }) => {
          console.log(data);
        })
        .catch(error => {
          console.error(error);
        })
        .then(() => {});
    },


      uncallQuiz(quizId,group) {
      console.log(quizId);
      console.log(group);
      axios

        .post("uncallQuiz", {
          quizId: quizId,
          
        })
        .then(({ data }) => {
          console.log(data);
        })
        .catch(error => {
          console.error(error);
        })
        .then(() => {});
    },


    deleteQuiz(quizId) {
      if (confirm("Confirmer la suppression ?"))
        axios
          .post("deleteQuiz", {
            Quiz_Id: quizId
          })
          .then(({ data }) => {
            this.quizzes = this.quizzes.filter(quiz => quiz.id != quizId);
          })
          .catch(error => {
            console.error(error);
          })
          .then(() => {});
    },
    onQuizClick(quiz) {
      this.but = true;
      this.show1 = false;
      this.show2 = true;

      console.log(quiz);
      this.quiz = quiz.title;
      console.log(this.quiz);
      this.ss = false;
      axios
        .get("fetchQuizUsers/" + quiz.id)
        .then(({ data }) => {
          this.quizUsers = data;
          console.log(data);
          this.answers = [];
        })
        .catch(error => {
          console.error(error);
        });
    },
    onQuizUserClick(questions, username) {
     let m = 0;
     let c=0;
      this.counterr = 0;
      this.ss = true;
      this.student = username;
      this.show2 = false;
      this.show22 = true;
      this.show3 = true;

      this.questions = questions;
    
       for(var i=0;i<this.questions.length;i++){
          this.counterr += m;
          m=0;
         for(var j=0;j<this.questions[i].choices.length;j++){
             if (this.questions[i].choices[j].is_chosen && this.questions[i].choices[j].is_correct) {
                m += this.questions[i].choices[j].point;

           

          }

          else if( this.questions[i].choices[j].is_chosen && this.questions[i].choices[j].is_correct==0 ){
             m=0;
             
             break;

          }


         }


       }
       this.counterr += m;

       for(var i=0;i<this.questions.length;i++){
         
         for(var j=0;j<this.questions[i].choices.length;j++){
            
               c+= this.questions[i].choices[j].point;

          

         }


       }

      console.log(c+"note totale");

      c=(20*this.counterr)/c;

      this.counterr = c.toFixed(2);




    },
    butt() {
      console.log("ss");
      var c = 0;
      if (this.quiz != null && this.student == null) {
        this.quiz = null;
        this.show1 = true;
        this.but = false;
        this.show2 = false;
      }

      if (this.student != null) {
        this.student = null;

        this.show2 = true;
        this.show22 = false;
        this.show3 = false;
        this.ss = false;
      }
    }
  }
};
</script>
<style scoped>
.ss {
  background-color: green;
}
.rr {
  background-color: red;
}
.gg {
  background-color: gray;
}
.titre2 {
  font-size: 25px;
  font-family: "Lucida Console", Monaco, monospace;
}
.titre1 {
  font-size: 25px;
  font-family: "Arial Black", Gadget, sans-serif;
}
.all {
  position: absolute;
  left: 70px;
  margin-bottom: 70px;
}
.all2 {
  position: absolute;
  left: 70px;
  top: 100px;
}
.butt {
  position: absolute;
  left: 800px;
  margin-top: 50px;
}

.pp {
  border-radius: 0;
  box-shadow: 5px 5px 15px #80c1ff;
}
.pp:hover {
  background: #b3daff;
  border-radius: 5px;
  border-radius: 5px;
  border: none;
  box-shadow: 5px 5px 15px #80c1ff;
}
</style>
