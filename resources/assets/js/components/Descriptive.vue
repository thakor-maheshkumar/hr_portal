<template>
  <div class="main-questions">
    <div class="myQuestion" v-for="(question, index) in questions">
      <div class="row">
        <div class="col-md-6">
          <blockquote>
            Total Questions &nbsp;&nbsp;{{ index+1 }} / {{questions.length}}
          </blockquote>

          <p class="question">Q. &nbsp;{{question.question}} ({{question.marks}})</p>
         <div class="row" v-if="question.code_snippet !== null">
            
          </div>
          <form class="myForm" action="/quiz_start" v-on:submit.prevent="createQuestion(question.id, question.answer, auth.id, question.topic_id)" method="post">
           <!-- <textarea class="form-control" ckeditor :editor="editor" placeholder="answer" v-model="result.user_answer" :config="editorConfig"></textarea> -->
           <ckeditor :editor="editor" v-model="result.user_answer" :config="editorConfig"></ckeditor>
            <div class="row">
              <div class="col-md-6 col-xs-8">
                <button type="submit" class="btn btn-wave btn-block nextbtn">Next</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-6">
          <div class="question-block-tabs" v-if="question.question_img !=''">
            <ul class="nav nav-tabs tabs-left">
              <li v-if="question.question_img !=' '" class="active"><a href="#image" data-toggle="tab">Question Image</a></li>
              <li v-if="question.question_video_link != null"><a href="#video" data-toggle="tab">Question Video</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="image" v-if="question.question_img !=' '">
                <div class="question-img-block">
                  <img :src="'../images/questions/'+question.question_img" class="img-responsive" alt="question-image">
                </div>
              </div>
              <div class="tab-pane fade" id="video" v-if="question.question_video_link != null">
                <div class="question-video-block">
                  <h3 class="question-block-heading">Question Video</h3>   
                  <iframe :id="'video'+(index+1)" width="460" height="345" :src="question.question_video_link" frameborder="0" allowfullscreen></iframe>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <li v-for="item in questions" :key="questions.id">
    {{ item.question }}
  </li> -->
  </div>
</template>


<script>
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
export default {

  props: ['topic_id'],

  data () {
    return {
      questions: [],
       answers: [],
      auth: [],
      result:{
        question_id: '',
        answer: '',
        user_id: '',
        user_answer:'',
        topic_id: '',
      },
      editor: ClassicEditor,
      //editorData: '<p>Content of the editor.</p>',
      editorConfig: {
          // The configuration of the editor.
      }
    }
  },

  created () {
    this.fetchQuestions();
  },

  methods: {

    fetchQuestions() {
      //alert('method check');
      this.$http.get(`${this.$props.topic_id}/des`).then(response => {
        this.questions = response.data.questions;
        this.auth = response.data.auth;
        console.log(this.questions);
      }).catch((e) => {
        console.log(e)
      });
    },

    createQuestion(id, ans, user_id, topic_id) {
      this.result.question_id = id;
      this.result.answer = ans;
      this.result.user_id = user_id;
      this.result.topic_id = this.$props.topic_id;
      this.$http.post(`${this.$props.topic_id}/quiz`, this.result).then((response) => {
        console.log('request completed');
      }).catch((e) => {
        console.log(e);
      });
      this.result.user_answer ='';
      this.result.topic_id = '';
    },
    next() {
      this.step++;
    },
  }

}
</script>
