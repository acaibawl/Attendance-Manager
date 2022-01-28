const getAbilities = (role: number): Array<Ability> => {
    const abilities = new Array<Ability>();
    if(role == 30) abilities.push("se");
    if(role >= 20) abilities.push("admin");
    if(role >= 10) abilities.push("manager");
    if(role >= 0) abilities.push("user");
    return abilities;
}

type Ability = "se" | "admin" | "manager" | "user";

const can = (user: any, needAbility: Ability): boolean => {
    return getAbilities(user.role).includes(needAbility);
}

export default can;
