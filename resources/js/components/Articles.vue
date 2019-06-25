<template>
  <div>
    <h2>Articles</h2>
    <form @submit.prevent="onAddArticle()">
      <div class="input-field col s4">
        <input type="text" placeholder="Article Title"
        v-model="article.title"
        >
        <textarea class="materialize-textarea" placeholder="Article Body"
        v-model="article.body"></textarea>
      </div>
      <button type="submit" class="btn btn-small blue">Save</button>
    </form>
    <div v-for="article in articles" v-bind:key="article.id" class="col s8 m4">
      <div class="card">
        <div class="card-content">
          <div class="card-title">
            <h3>{{ article.title }}</h3>
          </div>
          <p>
            {{ article.body }}
          </p>
        </div>
        <div class="card-action">
          <button class="btn btn-small red" @click="onDeleteArticle(article.id)">Delete</button>
          <button class="btn btn-small teal" @click="onEditArticle(article)">Edit</button>
        </div>
      </div>
    </div>
    <ul class="pagination center">
      <li v-bind:class="[{ disabled : !pagination.prev_page_url }]" class="disabled">
        <a href="#!"><i class="material-icons"
        @click="fetchArticles(pagination.prev_page_url)"
        >chevron_left</i></a>
      </li>
      <li class="waves-effect disabled"><a href="#!">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
      <li v-bind:class="[{ disabled : !pagination.next_page_url }]" class="waves-effect">
        <a href="#!" @click="fetchArticles(pagination.next_page_url)"><i class="material-icons">chevron_right</i></a></li>
    </ul>
    
  </div>
</template>

<script>
export default {
  data() {
    return {
      articles: [],
      article: {
        id: '',
        title: '',
        body: ''
      },
      article_id: '',
      padination: {},
      edit: false
    }
  },
  created() {
    this.fetchArticles();
  },
  methods: {
    fetchArticles(page_url) {
      let vm = this;

      page_url = page_url || '/api/articles'
      fetch(page_url)
        .then(res => res.json())
        .then(res  => {
          this.articles = res.data
          vm.makePagination(res.meta, res.links)
        })
        .catch(err => console.log(err));
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      }
      this.pagination = pagination;
    },
    onDeleteArticle(id) {
      if (confirm('Are you sure ?')) {
        fetch(`api/article/${id}`, {
          method: 'delete'
        })
        .then(res => res.json())
        .then(data => {
          alert('Article Removed');
          this.fetchArticles();
        })
        .catch(err => console.log(err));
      }
    },
    onAddArticle() {
      if (this.edit === false) {
        // Add
        fetch('api/article', {
          method: 'post',
          body: JSON.stringify(this.article),
          headers: {
            'content-type': 'application/json',
          }
        })
        .then(res => res.json())
        .then(data => {
          this.article.title = '';
          this.article.body = '';
          alert('Article Saved!');
          this.fetchArticles();
        })
        .catch(err => console.log(err))
      } else {
        // update
        fetch('api/article', {
          method: 'put',
          body: JSON.stringify(this.article),
          headers: {
            'content-type': 'application/json',
          }
        })
        .then(res => res.json())
        .then(data => {
          this.article.title = '';
          this.article.body = '';
          alert('Article Updated!');
          this.fetchArticles();
        })
        .catch(err => console.log(err))
      }
    },
    onEditArticle(article) {
      this.edit = true;
      this.article.id = article.id;
      this.article.article_id = article.id;
      this.article.title = article.title;
      this.article.body = article.body;

    }
  }
}
</script>
