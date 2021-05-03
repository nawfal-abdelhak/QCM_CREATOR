<template>
  <div class="row">
    <div class="col-12">
      <vcl-list v-if="fetching"></vcl-list>
    </div>
    <!-- <div class="col-12">
      <div class="row"><div class="col-6">fff</div><div class="col-6">ttt</div></div>
    </div>-->
    <div class="col-12">
      <div class="row">
        <div class="col-lg-3 col-md-6" v-for="(quiz,quizindex) in quizzes" :key="quiz.id" style="margin-bottom:6px;">
          <div class="card pp">
            <div class="card-body">
              <h3 style="color:black">{{quiz.title}}</h3>
              <h5>{{quiz.created_at}}</h5>
              <p
                v-if="quiz.note"
                class="card-text"
                style="font-size:15px;"
              >votre note {{quiz.note}}/20</p>
              <p
                v-if="!quiz.note"
                class="card-text"
                style="font-size:15px;"
              >vous devez repondre a ce qcm</p>
              <button
                v-if="!quiz.note &&  quiz.note!=0 "
                type="button"
                class="btn "
                style="background-color:#80d4ff"
                @click="fetchQuiz(quiz.id,quizindex) "
              >repondre</button>
              <button v-if="quiz.note<12 &&  quiz.note " type="button" style="background-color:#80d4ff"  class="btn ">rattrapage</button>
              <button v-if="quiz.note>=12" type="button" style="background-color:#80d4ff"  class="btn "> validé</button>

            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="cdn" class="static" style="border-style: dotted solid; ">{{ reversedMessage }}</div>

    <div class="col-12">
      <div class="inputArea" v-for="(question, questionIndex) in questions" :key="questionIndex">
        <div
          style="font-weight: bold;color: #0070C0;font-size: 1.3em"
          class="mb-2"
        >Question {{questionIndex + 1}}</div>
        <div
          style="font-weight: bold;color: #0070C0;font-size: 1.2em "
          class="mb-2"
        >{{question.text}}</div>

        <div
          v-if="question.image"
          v-bind:style="{ height: height + 'px', width: width + 'px',position:relative }"
          style="margin-bottom:6px"
        >
          <vue-draggable-resizable
            :draggable="false"
            :max-width="800"
            :max-height="800"
            v-bind:width="width"
            v-bind:height="height"
            @dragging="onDrag"
            @resizing="onResize"
          >
            <p>
              <img v-bind:width="width" v-bind:height="height" v-bind:src=" question.image" />
            </p>
          </vue-draggable-resizable>
        </div>

        <div class="inputArea" v-for="(choice, choiceIndex) in question.choices" :key="choiceIndex">
          <div class="mb-3">
            <input type="checkbox" v-model="choice.isChosen" />
            <label style="font-size: 18px  ">{{ choice.text }}</label>
          </div>
        </div>
        <hr style=" border-top: 1px solid blue;" />
      </div>
    </div>
    <div class="col-12">
      <button v-if="show1" class="btn btn-primary" @click="ss()">Send</button>
    </div>
    <div v-if="show1" class="fixed">
      <div class="des">{{note}}</div>
    </div>
    <!--send() -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      show1: false,
      relative: "relative",
      width: 200,
      height: 200,
      x: 0,
      y: 0,

      countDown: 0,
      cdn: false,
      counter: 0,
      change: false,
      fetching: true,
      quizzes: [],
      questions: [],
      answers: [],
      test: [],
      note: null,
      show: false
    };
  },
  computed: {
    reversedMessage() {
      // `this` points to the vm instance
      var x;
      x = this.countDown / 60;
      var a = parseInt(x);
      let y;
      y = this.countDown % 60;

      return a + ":" + y;
    }
  },

  created() {
    this.fetchQuizz_user();
    this.fetchQuizzes();
    window.addEventListener("beforeunload", this.handler);
  },

  mounted() {
    Echo.channel("group." + Laravel.user.group)
      .listen("QuizCreated", ({ quiz }) => {
        console.log(quiz);
        this.fetchQuizzes();
        // this.quizzes.push(quiz);
      })
      .listen("AnotherEvent", ({ data }) => {
        console.log(data);
      });
    if (this.$route.params.quizId)
      console.log("quizId", this.$route.params.quizId);
  },
  methods: {
    handler: function handler(event) {

        this.sendanswers();
    },

    onResize: function(x, y, width, height) {
      this.x = x;
      this.y = y;
      this.width = width;
      this.height = height;
    },
    onDrag: function(x, y) {
      this.x = x;
      this.y = y;
    },

    countDownTimer() {
      if (this.countDown > 0) {
        setTimeout(() => {
          this.countDown -= 1;
          this.countDownTimer();
        }, 1000);
      }  else if (this.countDown == 0) {

        location.reload();
      }
    },
    ss(){
      location.reload();

    },

    fetchQuizzes() {
      var c = 0;
      axios
        .get("fetchQuizzes")
        .then(({ data }) => {
          console.log(data);

          this.quizzes = data;
        })
        .catch(error => {
          console.error(error);
        })
        .then(() => {
          this.fetching = false;
        });
    },
    fetchQuiz(quizId, quizindex) {
      this.showsend();
      var c = 0;

      this.countDown = this.quizzes[quizindex].timer * 60;
      axios
        .get("fetchQuiz/" + quizId)
        .then(({ data }) => {
          console.log(data[0].quiz_id);
          for (var i = 0; i < this.test.length; i++) {
            if (this.test[i] == data[0].quiz_id) {
              c = 1;

              break;
            }
          }
          if (c == 0) {
            this.questions = data;
            console.log(this.questions);
            this.cdn = true;
            this.countDownTimer();
          }
        })
        .catch(error => {
          console.error(error);
        });
    },

    sendanswers() {
      var m = 0;
      var c = 0;

      this.countDown = -1;
      console.log(this.questions);

      // this.questions.forEach(question =>
      //   question.choices.forEach(choice => {
      //     if (choice.isChosen == choice.is_correct && choice.is_correct == 1) {
      //       this.counter += choice.point;
      //     }
      //   })
      // );

      for (var i = 0; i < this.questions.length; i++) {
        this.counter += m;
        m = 0;
        for (var j = 0; j < this.questions[i].choices.length; j++) {
          if (
            this.questions[i].choices[j].isChosen &&
            this.questions[i].choices[j].is_correct
          ) {
            m += this.questions[i].choices[j].point;


          } else if (
            this.questions[i].choices[j].isChosen &&
            this.questions[i].choices[j].is_correct == 0
          ) {
            m = 0;

            break;
          }
        }
      }

      this.counter += m;

      for (var i = 0; i < this.questions.length; i++) {
        for (var j = 0; j < this.questions[i].choices.length; j++) {
          c += this.questions[i].choices[j].point;
        }
      }

      console.log(c + "note totale");

      c = (20 * this.counter) / c;

      this.counter = c.toFixed(2);

      axios

        .post("sendAnswers", {
          note: this.counter,
          quiz_id: this.questions[0].quiz_id,
          questions: this.questions
        })
        .then(({ data }) => {
          console.log(data);
          location.reload();
        })
        .catch(error => {
          console.error(error);
        })
        .then(() => {});
    },

    fetchQuizz_user() {
      axios
        .get("fetchQuizz_user")
        .then(({ data }) => {
          this.test = data;
          console.log(this.test[0]);
        })
        .catch(error => {
          console.error(error);
        })
        .then(() => {
          this.fetching = false;
        });
    },

    showsend() {
      this.show1 = true;
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
.static {
  position: relative;

  top: 50px;
  left: 600px;
  font-size: 20px;
}
.pp {
  border-radius: 0;
  box-shadow: 5px 5px 15px #80c1ff;
  font-family: "raleway", sans-serif;
  font-size: 14px;
  font-weight: 400;
  color: #777;
}

.pp:hover {
  background: #80c1ff;
  border-radius: 5px;
  border-radius: 5px;
  border: none;
  box-shadow: 5px 5px 15px #80c1ff;
}
</style>
