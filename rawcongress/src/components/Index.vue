
<template>
  <div>
    <h1>Raw Congress</h1>
    <div class="cm__chamber">
      <h2>House Members</h2>
      <ol>
        <li v-for="member in house_members">
          <strong>House Member</strong><br />
          {{ member.last_name }}, {{ member.first_name }},
          <span v-if="member.party === 'R'">Republican, </span>
          <span v-else-if="member.party === 'D'">Democratic, </span>
          {{ member.state }}
        </li>
      </ol>
    </div>
    <div class="cm__chamber">
      <h2>Senate Members</h2>
      <ol>
        <li v-for="member in senate_members">
          <strong>Senate Member</strong><br />
          {{ member.last_name }}, {{ member.first_name }},
          <span v-if="member.party === 'R'">Republican, </span>
          <span v-else-if="member.party === 'D'">Democratic, </span>
          {{ member.state }}
        </li>
      </ol>
    </div>
  </div>
</template>

<script>
/* eslint-disable */
export default {
  name: 'index',
  data: function () {
    return {
      house_members: [],
      senate_members: []
    }
  },
  methods: {
    getMembers(member_type) {
      const data = (member_type === 'house') ? this.house_members : this.senate_members;
      var instance = this.axios.create({
        baseURL: 'https://api.propublica.org/congress/v1',
        headers: { 'X-Api-key': 'PPo8NOUWRG9i9WcBKJVIVacNERznlT50adGL56wN' }
      });

      instance.get(`https://api.propublica.org/congress/v1/114/${member_type}/members.json`).then((response) => {
         console.log(response);
         const cm = response.data.results[0].members;
         console.log(cm);
         for(var i = 0; i < cm.length; i++) {
          data.push(
            {
              last_name  : cm[i].last_name,
              first_name : cm[i].first_name,
              party      : cm[i].party,
              state      : cm[i].state,
            });
         }
      });
    },
  },
  mounted() {
    this.getMembers('house');
    this.getMembers('senate');
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
.cm__chamber {
  display: inline-block;
  vertical-align: top;
}
ul {
  list-style-type: none;
  padding: 0;
}

a {
  color: #42b983;
}
</style>
