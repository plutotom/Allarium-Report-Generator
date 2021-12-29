unique = ["item1", "item2", "item3"];

obj = {
  kxpaqagvebrjr3lzlps: {
    question: [
      {
        question_name: "item1",
        form_id: 32,
      },
      {
        question_name: "Group 1 Question is 4",
        form_id: 33,
      },
    ],
    category_id: "kxpaqagvebrjr3lzlps",
    category_title: "cat 1",
  },
  kxpaqd2ypv4rvn16tu: {
    question: [
      {
        question_name: "Group 1 Question is 2",
      },
      {
        question_name: "3-4",
      },
      {
        question_name: "item2",
      },
    ],
    category_id: "kxpaqd2ypv4rvn16tu",
    category_title: "cat 2",
  },
  kxpavo7w8rg870ozuff: {
    question: [
      {
        question_name: "Group 1 Question is 3",
        form_id: 32,
      },
      {
        question_name: "Group 1 Question is 4",
        form_id: 33,
      },
    ],
    category_id: "kxpavo7w8rg870ozuff",
    category_title: "cat 3",
  },
};

var new_obj = [];
unique.forEach((unique_question) => {
  // for each object in obj
  Object.keys(obj).forEach((category_id) => {
    // for each question in the object
    obj[category_id].question.forEach((question) => {
      // if the question name is the same as the unique_question
      if (question.question_name === unique_question) {
        // add the question to the category
        new_obj.push(question);
      }
    });
  });
});

// log new_obj
console.log(new_obj);
