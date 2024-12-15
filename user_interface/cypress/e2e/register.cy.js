

describe('admin login works', () => {
  it('admin login works.', () => {   
    // NOTICE: This needs to be run /w the above registration
    const emailAdmin = 'test-user5@test.cz';
    const passwordAdmin = 'test-user5';

    cy.visit('http://localhost:5173');
    cy.wait(3000);    

    // Login
    cy.get('[id="email"]').type(emailAdmin);
    cy.get('[id="password"]').type(passwordAdmin);
    cy.get('[id="login-btn"]').click();
  });
});
