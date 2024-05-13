import { server } from "./servidor";

const myFetch = (page, body) => {
  fetch(server + page, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body,
  })
    .then((response) => response.text())
    .then((data) => {
      return data;
    })
    .catch((error) => {
      console.error("Error al enviar los datos:", error);
    });
};
