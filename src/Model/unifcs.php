context('unifcs',()=>){
    it('acessar login da unifcs',=>{
    cy.visit('https://portal.unifacs.br/matriculaweb/portaldoestudante/default.asp');
    cy.get('#loginPessoa').type('730180006');
    cy.get('#senhaPessoa').type('01914559');
     cy.get('[type="submit"]').click();
     cy.get(':nth-child(1)'>#menupai> .collapsed);   
    });
}