
var searchFocus=false;
var M = Math;
TweenMax.defaultOverwrite = "all";
var my;
relatedCharacters = $("#related-characters").html();
relatedJobs = $("#related-jobs").html();
var NG = {
	ttItem: document.getElementById("ttItem"),
	ttItemName: document.getElementById("ttItemName"),
	ttItemMsg: document.getElementById("ttItemMsg")
};
g.view = "Game";
maxHpBuff=0;
skinLikeNatureStatus=false;
phantomPlateStatus=false;
thistlecoatStatus=false;
chantOfBattleStatus=false;
sowStatus=false;
anthemDeArmsStatus=false;
symbolOfRyltanStatus=false;
divineAegisStatus=false;
yaulpStatus=false;
callOfTheAncientsStatus=false;
bloodlustStatus=false;
markOfJudgementStatus=false;
armorOfFaithStatus=false;
eagleStrikeStatus=false;
chillStatus=false;
alacrityStatus=false;
var war = {},
	mnk = {},
	rog = {},
	pal = {},
	sk = {},
	rng = {},
	brd = {},
	dru = {},
	clr = {},
	shm = {},
	nec = {},
	enc = {},
	mag = {},
	wiz = {};
war.tn = [
	'',
	"Kick",
	"Pummel",
	"Bulwark",
	"Shockwave",
	"Slam",
	"Hemorrhage",
	"Absorb Spell",
	"Intrepid Might",
	"Avenging Strike",
	"Enrage",
	"Subjugate",
	"Decisive Blow"
];
war.tal = [
	'',
	"Improve Kick's damage and its interrupt rate",
	"Improve Pummel by using a shield to increase its damage",
	"Improve Bulwark's damage reduction",
	"Improve Shockwave's damage using a special technique with your shield",
	"Convert Slam to hit 3 targets",
	"Improve Hemorrhage's damage",
	"Convert Absorb Spell to Reflect. Reflect causes spell damage on all enemies based on monster spell damage.",
	"Improve Intrepid Might's damage",
	"Improve Avenging Strike's damage",
	"After Using Enrage, your next physical attack's damage is amplified",
	"Improve Subjugate's damage",
	"Improve Decisive Blow's damage"
];
war.tx = [
	0,
	'192',
	512,
	1024,
	448,
	256,
	384,
	704,
	1088,
	320,
	832,
	576,
	640
];
rog.tx = [
	0,
	'512',
	'832',
	'256',
	'448',
	'192',
	'576',
	'896',
	'640',
	'320',
	'1024',
	'384',
	'768'
];
mnk.tx = [
	0,
	'256',
	'960',
	'1088',
	'768',
	'576',
	'320',
	'704',
	'448',
	'192',
	'512',
	'640',
	'1024'
];
pal.tx = [
	0,
	'192',
	'448',
	'512',
	'960',
	'256',
	'384',
	'704',
	'1088',
	'320',
	'576',
	'768',
	'896'
];
sk.tx = [
	0,
	'256',
	'320',
	'128',
	'960',
	'192',
	'512',
	'448',
	'576',
	'384',
	'1024',
	'768',
	'640'
];
rng.tx = [
	0,
	'192',
	'896',
	'704',
	'768',
	'320',
	'384',
	'576',
	'640',
	'256',
	'960',
	'1088',
	'448'
];
brd.tx = [
	0,
	'256',
	'384',
	'896',
	'960',
	'192',
	'576',
	'832',
	'1088',
	'448',
	'512',
	'704',
	'1024'
];
dru.tx = [
	0,
	'256',
	'320',
	'448',
	'896',
	'384',
	'640',
	'704',
	'768',
	'192',
	'512',
	'576',
	'832'
];
clr.tx = [
	0,
	'192',
	'896',
	'384',
	'704',
	'256',
	'576',
	'960',
	'640',
	'448',
	'512',
	'768',
	'832'
];
shm.tx = [
	0,
	'192',
	'384',
	'512',
	'768',
	'256',
	'576',
	'640',
	'832',
	'896',
	'960',
	'1024',
	'704'
];
nec.tx = [
	0,
	'384',
	'576',
	'704',
	'960',
	'1024',
	'512',
	'640',
	'896',
	'192',
	'256',
	'320',
	'832'
];
enc.tx = [
	0,
	'192',
	'384',
	'896',
	'704',
	'320',
	'512',
	'960',
	'576',
	'256',
	'448',
	'640',
	'768'
];
mag.tx = [
	0,
	'192',
	'896',
	'256',
	'704',
	'1088',
	'384',
	'576',
	'640',
	'960',
	'320',
	'1024',
	'512'
];
wiz.tx = [
	0,
	'256',
	'384',
	'576',
	'1024',
	'192',
	'512',
	'640',
	'768',
	'1088',
	'448',
	'896',
	'960'
];
war.ty = [
	0,0,0,0,0,0,0,0,0,0,0,0,0
];
rog.ty = [
	0,0,0,0,0,0,0,0,0,0,0,0,0
];
mnk.ty = [
	0,0,0,0,0,0,0,0,0,0,0,0,0
];
pal.ty = [
	0,0,0,0,0,0,0,0,0,0,0,0,0
];
sk.ty = [
	0,0,0,-64,0,0,0,0,0,0,0,0,0
];
rng.ty = [
	0,0,0,0,0,0,0,0,0,0,0,0,0
];
brd.ty = [
	0,0,0,0,0,0,0,0,0,0,0,0,0
];
dru.ty = [
	0,0,0,0,0,0,0,0,0,0,0,0,0
];
clr.ty = [
	0,0,0,0,0,0,0,0,0,0,0,0,0
];
shm.ty = [
	0,0,0,0,0,0,0,0,0,0,0,0,0
];
nec.ty = [
	0,0,0,0,0,0,0,0,0,0,0,0,0
];
enc.ty = [
	0,0,0,0,0,0,0,0,0,0,0,0,0
];
mag.ty = [
	0,0,0,0,0,-128,0,0,0,0,0,0,0
];
wiz.ty = [
	0,0,0,0,0,0,0,0,0,0,0,0,0
];
mnk.tn = [
	'',
	"Eagle Strike",
	"Stone Fist Reversal",
	"Inner Peace",
	"Chakra Blast",
	"Windmill Kick",
	"Cheetah Strike",
	"Flying Kick",
	"Dragon Strike",
	"Tiger Strike",
	"Crane Kick",
	"Ancestral Flurry",
	"Intimidation"
];
mnk.tal = [
	'',
	"Improve Eagle Strike's damage",
	"Improve Stone Fist Reversal's damage",
	"Reduce damage taken while Inner Peace is active",
	"Improve Chakra Blast's damage",
	"Improve Windmill Kick's damage",
	"Improve Cheetah Strike's damage",
	"Improve Flying Kick's damage and all elemental damage",
	"Improve Dragon Strike's damage",
	"Improve Tiger Strike's damage",
	"Improve Crane Kick's damage",
	"Improve Ancestral Flurry's damage",
	"Feared targets received amplified physical damage"
];
rog.tn = [
	'',
	"Lacerate",
	"Evade",
	"Sonic Strike",
	"Mirage Strike",
	"Shadow Strike",
	"Backstab",
	"Cold Blood",
	"Stagger Shot",
	"Hyper Strike",
	"Illusive Mist",
	"Widow Strike",
	"Prowling Gash"
];
rog.tal = [
	'',
	"Improve Lacerate's damage",
	"Improve all damage while Evade is active",
	"Improve Sonic Strike's damage",
	"Improve Mirage Strike's damage",
	"Improve Shadow Strike's damage",
	"Improve Backstab's damage",
	"Reduce Cold Blood's Cooldown",
	"Improve Stagger Shot's damage",
	"Improve Hyper Strike's skill haste bonus",
	"Increase all damage while in illusive form",
	"Improve Widow Strike's damage",
	"Improve Prowling Gash's damage",
];
pal.tn = [
	'',
	"Slam",
	"Lay Hands",
	"Greater Healing",
	"Valor",
	"Rebuke",
	"Vengeance",
	"Ardent Judgment",
	"Divine Providence",
	"Purge",
	"Holy Might",
	"Yaulp",
	"Flash of Light"
];
pal.tal = [
	'',
	"Improve Slam's damage",
	"Reduce Lay Hands's cooldown",
	"Improve Greater Healing's healing power",
	"Improve Valor's armor and health bonuses",
	"Improve Rebuke's damage",
	"Improve Vengeance's damage",
	"Improve Ardent Judgment's damage",
	"Improve Divine Providence's power",
	"Improve Purge's damage",
	"Improve Holy Might's damage",
	"Improve Yaulp's damage",
	"Flash of light strikes your target for arcane damage"
];
sk.tn = [
	'',
	"Crescent Cleave",
	"Death Strike",
	"Resist Cold",
	"Shadow Vortex",
	"Slam",
	"Life Tap",
	"Harm Touch",
	"Dooming Darkness",
	"Gasping Frenzy",
	"Summon Dead",
	"Fear",
	"Heat Blood"
];
sk.tal = [
	'',
	"Improve Crescent Cleave's damage",
	"Improve Death Strike's damage",
	"Add a banshee aura to Resist Cold, causing damage to anyone that strikes you.",
	"Improve Shadow Vortex's damage reduction",
	"Improve Slam's damage",
	"Improve Life Tap's damage",
	"Improve Harm Touch's damage",
	"Improve Dooming Darkness's damage",
	"Improve Gasping Frenzy's damage",
	"Improve your minion's damage",
	"Improve damage on feared targets",
	"Improve Heat Blood's damage"
];
rng.tn = [
	'',
	"Kick",
	"Thistlecoat",
	"Snare",
	"Warder\'s Rift",
	"Counter Shot",
	"Trueshot Arrow",
	"Faerie Flame",
	"Ignite",
	"Rapid Shot",
	"Feet Like Cat",
	"Spirit of the Wolf",
	"Volley Shot"
];
rng.tal = [
	'',
	"Improve Kick's damage and its interrupt rate",
	"Adds a Health Bonus to Thistlecoat",
	"Converts auto attack into a rapid flurry of hits",
	"Reduce the damage mitigation of Warder's Rift for your own attacks.",
	"Improve Counter Shot damage",
	"Improve Trueshot Arrow's damage",
	"Improve Faerie Flame's Damage",
	"Improve Ignite's damage",
	"Improve Rapid Shot's damage",
	"Feet Like Cat will also add skill haste",
	"Improve Spirit of the Wolf by adding a lightning strike chance to your arrows",
	"Improve Volley Shot's damage"
];
brd.tn = [
	'',
	"Chant of Battle",
	"Hymn of Restoration",
	"Anthem De Arms",
	"Euphonic Hymn",
	"Chords of Dissonance",
	"Elemental Rhythms",
	"Chords of Clarity",
	"Desperate Dirge",
	"Song of the Sirens",
	"Boastful Bellow",
	"Consonant Chain",
	"Shield of Songs",
];
brd.tal = [
	'',
	"Chant of Battle adds physical damage",
	"Improve Hymn of Restoration's healing power and your maximum health",
	"Improve Anthem De Arms's haste and add attack power",
	"Improve Euphonic Hymn's physical damage enhancement",
	"Improve Chords of Dissonance's damage",
	"Improve Elemental Rhythms's resistances",
	"Improve Chords of Clarity's mana regeneration",
	"Improve Desperate Dirge's damage",
	"Improve Song of the Sirens's charmed pet damage",
	"Improve Boastful Bellow's damage",
	"Improve Consonant Chain's slow power",
	"Improve Shield of Songs's shield health"
];
dru.tn = [
	'',
	"Drones of Doom",
	"Greater Healing",
	"Engulfing Roots",
	"Skin Like Nature",
	"Tornado",
	"Earthquake",
	"Hurricane",
	"Sylvan Creep",
	"Starfire",
	"Drifting Death",
	"Lightning Blast",
	"Volcano"
];
dru.tal = [
	'',
	"Improve Drones of Doom's damage",
	"Improve Greater Healing",
	"Add Poison Effect To Rooted Mobs",
	"Improve Skin Like Nature's Health Bonus",
	"Improve Tornado's damage",
	"Improve Earthquake's damage",
	"Improve Hurricane's damage",
	"Improve Sylvan Creep's damage",
	"Improve Starfire's damage",
	"Improve Drifting Death's damage",
	"Improve Lightning Blast's damage",
	"Improve Volcano's damage"
];
clr.tn = [
	'',
	"Smite",
	"Resolution",
	"Binding Earth",
	"Holy Wrath",
	"Sound of Force",
	"Martyr\'s Blessing",
	"Armor of Faith",
	"Guardian Angel",
	"Expel Corruption",
	"Searing Revelation",
	"Mark of Judgement",
	"Benediction"
];
clr.tal = [
	'',
	"Improve Smite's damage",
	"Improve Resolution by adding casting haste and health",
	"Add holy damage over time to Binding Earth",
	"Improve Holy Wrath's damage",
	"Improve Sound of Force's damage. Converts auto attack into a rapid flurry of hits",
	"Martyr's Blessing enhances all damage inflicted and received while the skill is active",
	"Improve Armor of Faith's armor bonus and add an attack haste effect.",
	"Improve Guardian Angel's shield strength",
	"Improve Expel Corruption's damage",
	"Add damage component to Searing Revelation",
	"Add Holy Nova explosion to Mark of Judgement",
	"Improve Benediction by adding explosive holy damage"
];
shm.tn = [
	'',
	"Frost Strike",
	"Togor\'s Insects",
	"Enstill",
	"Glacial Impact",
	"Scourge",
	"Poison Nova",
	"Affliction",
	"Devouring Plague",
	"Call of the Ancients",
	"Guardian Spirit",
	"Spirit of the Wolf",
	"Reclaim Blood"
];
shm.tal = [
	'',
	"Improve Frost Strike's damage",
	"Improve Togor's Insects by adding poison damage while the effect is active",
	"Improve Enstill by adding arcane damage damage while the effect is active",
	"Improve Glacial Impact's damage",
	"Improve Scourge's damage",
	"Improve Poison Nova's damage",
	"Improve Affliction's damage",
	"Improve Devouring Plague's damage",
	"Improve Call of the Ancients's buff power",
	"Improve Guardian Spirit's health and damage",
	"Improve Spirit of the Wolf's attack bonus",
	"Improve Reclaim Blood's healing power"
];
nec.tn = [
	'',
	"Drain Soul",
	"Ignite Blood",
	"Bond of Death",
	"Howling Terror",
	"Invoke Death",
	"Augment Death",
	"Corpse Explosion",
	"Detonate Soul",
	"Bone Spirit",
	"Cascading Darkness",
	"Invoke Fear",
	"Asystole"
];
nec.tal = [
	'',
	"Improve Drain Soul's damage",
	"Improve Ignite Blood's damage",
	"Improve Bond of Death's damage",
	"Improve Howling Terror by adding cold damage over time to all feared targets",
	"Improve Invoke Death by adding health and damage to your pet",
	"Improve Augment Death's damage and healing",
	"Improve Corpse Explosion's damage",
	"Improve Detonate Soul's damage",
	"Improve Bone Spirit's damage",
	"Improve Cascading Darkness's damage",
	"Improve Invoke Fear by enhancing all damage on feared targets",
	"Improve Asystole's damage"
];
enc.tn = [
	'',
	"Chaos Flux",
	"Color Shift",
	"Discordant Barrier",
	"Mystic Rune",
	"Cajoling Whispers",
	"Shiftless Deeds",
	"Enchant Weapon",
	"Alacrity",
	"Gasping Embrace",
	"Mesmerize",
	"Gravity Flux",
	"Tashania"
];
enc.tal = [
	'',
	"Improve Chaos Flux's damage",
	"Improve Color Shift by adding arcane damage",
	"Improve Discordant Barrier's armor and health",
	"Improve Mystic Rune's shield power",
	"Improve charmed mob's damage",
	"Improve Shiftless Deeds by adding cold damage over time",
	"Improve Enchant Weapon's damage",
	"Improve Alacrity by adding additional hits to auto attack",
	"Improve Gasping Embrace's damage",
	"Convert Mesmerize into Jubilee, a dazzling explosion that inflicts arcane damage. Jubilee does not mesmerize.",
	"Improve Gravity Flux's damage",
	"Improve Tashania by adding arcane damage over time"
];
mag.tn = [
	'',
	"Lava Bolt",
	"Shield of Lava",
	"Firestorm",
	"Armageddon",
	"Summon Elemental",
	"Burnout",
	"Reclaim Elements",
	"Elemental Fury",
	"Phantom Plate",
	"Frozen Orb",
	"Elemental Armor",
	"Psionic Storm"
];
mag.tal = [
	'',
	"Improve Lava Bolt's damage",
	"Improve Shield of Lava's damage",
	"Improve Firestorm's damage",
	"Improve Armageddon's damage",
	"Improve summoned elementals' health and damage",
	"Improve Burnout's damage and healing",
	"Improve Reclaim Elements's healing",
	"Improve Elemental Fury's damage",
	"Improve Phantom Plate's armor and health bonus",
	"Improve Frozen Orb's damage",
	"Improve Elemental Armor's resistances",
	"Improve Psionic Storm's damage"
];
wiz.tn = [
	'',
	"Charged Bolts",
	"Arcane Missiles",
	"Chain Lightning",
	"Mirror Images",
	"Ice Bolt",
	"Deep Freeze",
	"Glacial Spike",
	"Ice Comet",
	"Vizier\'s Shielding",
	"Fireball",
	"Harness Ether",
	"Meteor"
];
wiz.tal = [
	'',
	"Improve Charged Bolts' damage",
	"Improve Arcane Missiles' damage",
	"Improve Chain Lightning's damage",
	"Improve Mirror Images' damage",
	"Improve Ice Bolt's damage",
	"Improve Deep Freeze's damage",
	"Improve Glacial Spike's damage",
	"Improve Ice Comet's damage",
	"Improve Vizier\'s Shielding's armor and health",
	"Improve Fireball's damage",
	"Improve Harness Ether's damage amplification",
	"Improve Meteor's damage"
];
function initMY(){
	my = {
			name:"", 
			lastName:"", 
			gender:"", 
			job:"", 
			race:"", 
			level:null, 
			exp:0, 
			hp:0, 
			maxHp:0, 
			mp:0, 
			maxMp:0, 
			str:0, 
			sta:0, 
			agi:0, 
			dex:0, 
			wis:0, 
			intel:0, 
			cha:0, 
			oneHandSlash:0, 
			offense:0, 
			defense:0, 
			dualWield:0, 
			doubleAttack:0, 
			dodge:0, 
			parry:0, 
			riposte:0, 
			alteration:0, 
			evocation:0, 
			conjuration:0, 
			abjuration:0, 
			channeling:0, 
			twoHandSlash:0, 
			oneHandBlunt:0, 
			piercing:0, 
			twoHandBlunt:0, 
			handToHand:0, 
			svpoison:0, 
			svmagic:0, 
			svlightning:0, 
			svcold:0, 
			svfire:0, 
			gold:0, 
			zone:"", 
			playtime:0, 
			deaths:0, 
			mobsSlain:0, 
			championsSlain:0, 
			escapes:0, 
			totalGold:0, 
			uniquesFound:0, 
			setFound:0,
			raresFound:0, 
			magicFound:0, 
			upgrades:0, 
			raresSlain:0, 
			randomEvents:0, 
			scriptedEvents:0, 
			quests:0, 
			comboPermafrost:0, 
			comboKedgeKeep:0, 
			comboSolB:0, 
			comboMistmoore:0, 
			comboLowerGuk:0, 
			comboCazicThule:0, 
			comboPlaneofFear:0, 
			comboPlaneofHate:0, 
			comboOverall:0,
			ID:false, 
			subzone:1, 
			zoneN:"", 
			zoneH:"", 
			subzoneN:1, 
			subzoneH:1, 
			title: "", 
			difficulty: 1, 
			talent1:0, 
			talent2:0, 
			talent3:0, 
			talent4:0, 
			talent5:0, 
			talent6:0, 
			talent7:0, 
			talent8:0, 
			talent9:0,
			talent10:0, 
			talent11:0, 
			talent12:0, 
			hardcoreMode:false, 
			patch:0,
			story:"Intro"
	};
}
initMY();
g.speed = .5;
g.key = [
	'hp', 
	'mp',
	'str',
	'sta',
	'agi',
	'dex',
	'intel',
	'wis',
	'cha',
	'allStats',
	'hpRegen',
	'mpRegen',
	'armor',
	'enhancedArmor',
	'attack',
	'oneHandSlash',
	'twoHandSlash',
	'oneHandBlunt',
	'twoHandBlunt',
	'piercing',
	'handtohand',
	'offense',
	'dualWield',
	'doubleAttack',
	'defense',
	'dodge',
	'parry',
	'riposte',
	'alteration',
	'evocation',
	'conjuration',
	'abjuration',
	'channeling',
	'allSkills',
	'critChance',
	'critDamage',
	'phyMit',
	'magMit',
	'resistPoison',
	'resistMagic',
	'resistLightning',
	'resistCold',
	'resistFire',
	'allResist',
	'goldFind',
	'expFind',
	'thorns',
	'absorbPoison',
	'absorbMagic',
	'absorbLightning',
	'absorbCold',
	'absorbFire',
	'name',
	'rarity',
	'itemSlot',
	'type',
	'damage',
	'delay',
	'physicalDamage',
	'poisonDamage',
	'magicDamage',
	'lightningDamage',
	'coldDamage',
	'fireDamage',
	'enhancePhysical',
	'enhancePoison',
	'enhanceMagic',
	'enhanceLightning',
	'enhanceCold',
	'enhanceFire',
	'enhanceAll',
	'hpKill',
	'mpKill',
	'lightRadius',
	'runSpeed',
	'xPos',
	'yPos',
	'haste',
	'globalHaste',
	'castingHaste',
	'proc',
	'req',
	'flavorText',
	'upgrade',
	'weight',
	'enhancedDamage',
	'ias',
	'stun',
	'fear',
	'cold',
	'silence',
	'leech',
	'wraith',
	'quality'
];
g.val = [
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	'',
	0,
	'',
	'',
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	'',
	0,
	'',
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0
];
g.difficulty=1;
function initEq(){
	for(var i=0;i<=14;i++){
		P.eq[i] = {};
		for(var x=0, len=g.key.length; x<len;x++){
			P.eq[i][g.key[x]] = g.val[x];
		}
	}
}
initEq();
$.ajaxSetup({
	type:'POST',
	url: 'php/master1.php'
});
itemSprite = "https://i.imgur.com/gxfvcyu.png";
// functions
var asset = [];
var x = new Image();
x.src = itemSprite;
asset.push(x);
function parseItem(d, len, a){
	for(var i=0;i<len;i++){
		P[d][i].abjuration = a.shift()*1;
		P[d][i].absorbCold = a.shift()*1;
		P[d][i].absorbFire = a.shift()*1;
		P[d][i].absorbLightning = a.shift()*1;
		P[d][i].absorbMagic = a.shift()*1;
		P[d][i].absorbPoison = a.shift()*1;
		P[d][i].agi = a.shift()*1;
		P[d][i].allResist = a.shift()*1;
		P[d][i].allSkills = a.shift()*1;
		P[d][i].allStats = a.shift()*1;
		P[d][i].alteration = a.shift()*1;
		P[d][i].armor = a.shift()*1;
		P[d][i].attack = a.shift()*1;
		P[d][i].castingHaste = a.shift()*1;
		P[d][i].cha = a.shift()*1;
		P[d][i].channeling = a.shift()*1;
		P[d][i].cold = a.shift()*1;
		P[d][i].coldDamage = a.shift()*1;
		P[d][i].conjuration = a.shift()*1;
		P[d][i].critChance = a.shift()*1;
		P[d][i].critDamage = a.shift()*1;
		P[d][i].damage = a.shift()*1;
		P[d][i].defense = a.shift()*1;
		P[d][i].delay = a.shift()*1;
		P[d][i].dex = a.shift()*1;
		P[d][i].dodge = a.shift()*1;
		P[d][i].doubleAttack = a.shift()*1;
		P[d][i].dualWield = a.shift()*1;
		P[d][i].enhanceAll = a.shift()*1;
		P[d][i].enhanceCold = a.shift()*1;
		P[d][i].enhanceFire = a.shift()*1;
		P[d][i].enhanceLightning = a.shift()*1;
		P[d][i].enhanceMagic = a.shift()*1;
		P[d][i].enhancePhysical = a.shift()*1;
		P[d][i].enhancePoison = a.shift()*1;
		P[d][i].enhancedArmor = a.shift()*1;
		P[d][i].enhancedDamage = a.shift()*1;
		P[d][i].evocation = a.shift()*1;
		P[d][i].expFind = a.shift()*1;
		P[d][i].fear = a.shift()*1;
		P[d][i].fireDamage = a.shift()*1;
		P[d][i].flavorText = a.shift();
		P[d][i].globalHaste = a.shift()*1;
		P[d][i].goldFind = a.shift()*1;
		P[d][i].handtohand = a.shift()*1;
		P[d][i].haste = a.shift()*1;
		P[d][i].hp = a.shift()*1;
		P[d][i].hpKill = a.shift()*1;
		P[d][i].hpRegen = a.shift()*1;
		P[d][i].ias = a.shift()*1;
		P[d][i].intel = a.shift()*1;
		P[d][i].itemSlot = a.shift();
		P[d][i].leech = a.shift()*1;
		P[d][i].lightRadius = a.shift()*1;
		P[d][i].lightningDamage = a.shift()*1;
		P[d][i].magMit = a.shift()*1;
		P[d][i].magicDamage = a.shift()*1;
		P[d][i].mp = a.shift()*1;
		P[d][i].mpKill = a.shift()*1;
		P[d][i].mpRegen = a.shift()*1;
		P[d][i].name = a.shift();
		P[d][i].offense = a.shift()*1;
		P[d][i].oneHandBlunt = a.shift()*1;
		P[d][i].oneHandSlash = a.shift()*1;
		P[d][i].parry = a.shift()*1;
		P[d][i].phyMit = a.shift()*1;
		P[d][i].physicalDamage = a.shift()*1;
		P[d][i].piercing = a.shift()*1;
		P[d][i].poisonDamage = a.shift()*1;
		P[d][i].proc = a.shift();
		P[d][i].quality = a.shift()*1;
		P[d][i].rarity = a.shift()*1;
		P[d][i].req = a.shift()*1;
		P[d][i].resistCold = a.shift()*1;
		P[d][i].resistFire = a.shift()*1;
		P[d][i].resistLightning = a.shift()*1;
		P[d][i].resistMagic = a.shift()*1;
		P[d][i].resistPoison = a.shift()*1;
		P[d][i].riposte = a.shift()*1;
		P[d][i].runSpeed = a.shift()*1;
		P[d][i].silence = a.shift()*1;
		P[d][i].sta = a.shift()*1;
		P[d][i].str = a.shift()*1;
		P[d][i].stun = a.shift()*1;
		P[d][i].thorns = a.shift()*1;
		P[d][i].twoHandBlunt = a.shift()*1;
		P[d][i].twoHandSlash = a.shift()*1;
		P[d][i].type = a.shift();
		P[d][i].upgrade = a.shift()*1;
		P[d][i].weight = a.shift()*1;
		P[d][i].wis = a.shift()*1;
		P[d][i].wraith = a.shift()*1;
		P[d][i].xPos = a.shift()*1;
		P[d][i].yPos = a.shift()*1;
	}
}
function submitSearch(){
	var search = $("#search").val();
	var host = 'https://nevergrind.com/';
	if(location.host!=='localhost'){
		host = 'localhost/ng/';
	}
	location.replace('index.php?character='+search);
}
$("#searchButton").on('click',function(){
	submitSearch();
});
$("#search").on('focus',function(){
	searchFocus = true;
}).on('blur', function(){
	searchFocus = false;
});
$(document).on('keyup',function(e){
	if(searchFocus){
		if(e.keyCode===13){
			submitSearch();
		}
	}
});

// this is cumulative so 276 exp needed for level 2 (376 total)
g.levelMax = [100,276,441,624,825,1044,1281,1536,1809,//10
	2650,3014,3396,3796,4214,5400,5904,6426,6966,7524,
	9100,9744,10406,11086,11784,13750,14534,15336,16156,16994,
	19650,20584,21536,22506,23494,26600,27684,28786,29906,31044,
	34600,35834,37086,38356,39644,44100,45494,46906,48336,49784,
	54750,56304,57876,59466,61074,67100,68824,70566,72326,74104,
	81300,83204,85126,87066,89024,97500,99594,101706,103836,105984,
	115850,118144,120456,122786,125134,135750,138244,140756,143286,145834,
	166800,169614,172446,175296,178164,206550,209754,212976,216216,219474,
	267750,271544,275356,279186,
	283034, //94 - 283034
	676400, //95 - 676400 - 7045176
	3775584, //96 - 3775584 - 7721576
	23652286, //97 - 23652286 - 11497160
	68686338 // max value = 103835784
];
function setCurrentLevel(myExp){
	if(!myExp){
		myExp = my.exp;
	}
    var x = g.levelMax;
    var myLevel = 1;
	var sum = 0;
    for(var i=0, len=x.length; i<len; i++){
		sum+=x[i];
        if(sum>myExp){
            continue;
        }else{
            myLevel++;
            if(myLevel>=99){
                continue;
            }
        }
    }
	return myLevel;
}

function nextLevel(level){
	if(level===0){
		return 0;
	}
	if(!level){ 
		level = my.level;
	}
    var x = g.levelMax;
	var foo = 0;
	var next = level+1;
	for(var i=1;i<=98;i++){
		if(next>i){
			foo+=x[(i-1)];
		}
	}
	return foo;
}
function totalLevelExp(){
	var foo=0;
    var x = g.levelMax;
	for(var i=1;i<=98;i++){
		if(my.level>i){
			foo+=x[(i-1)];
		}
	}
	return foo;
}
function daysPlayed(){
	var days = 0;
	var timeLeft = my.playtime;
	if(timeLeft >=86400000){
		days = Math.floor(timeLeft/86400000);
		timeLeft = (timeLeft % 86400000);
	}
	return days
}
function hoursPlayed(){
	var hours = 0;
	var timeLeft = my.playtime;
	if(timeLeft >=86400000){
		var days = Math.floor(timeLeft/86400000);
		timeLeft = (timeLeft % 86400000);
	}
	if(timeLeft >= 3600000){
		hours = Math.floor(timeLeft/3600000);
		timeLeft = (timeLeft % 3600000);
	}
	return hours;
}

setEquipValues();
// get query string
if(window.location.search.indexOf("character=")!==-1){
	a = window.location.search.split("character=");
	var name = a[1].replace(/%27/, "'");
	name = name.replace(/%22/, '"');
	$.ajax({
		url: '../php/loadData1.php',
		data:{
			run:"loadMy",
			name: name,
			ng: "true"
		}
	}).done(function(data){
		var a = data.split("|");
		a.pop();
		my.name = a.shift();
		my.abjuration = a.shift()*1;
		my.agi = a.shift()*1;
		my.alteration = a.shift()*1;
		my.cha = a.shift()*1;
		my.championsSlain = a.shift()*1;
		my.channeling = a.shift()*1;
		my.conjuration = a.shift()*1;
		my.deaths = a.shift()*1;
		my.defense = a.shift()*1;
		my.dex = a.shift()*1;
		my.difficulty = a.shift()*1;
		my.dodge = a.shift()*1;
		my.doubleAttack = a.shift()*1;
		my.dualWield = a.shift()*1;
		my.epicQuests = a.shift()*1;
		my.escapes = a.shift()*1;
		my.evocation = a.shift()*1;
		my.exp = a.shift()*1;
		my.gender = a.shift();
		my.gold = a.shift()*1;
		my.handtohand = a.shift()*1;
		my.hardcoreMode = a.shift();
		my.hp = a.shift()*1;
		my.intel = a.shift()*1;
		my.job = a.shift();
		my.lastName = a.shift();
		my.level = a.shift()*1;
		my.magicFound = a.shift()*1;
		my.maxHp = a.shift()*1;
		my.maxMp = a.shift()*1;
		my.mobsSlain = a.shift()*1;
		my.mp = a.shift()*1;
		my.offense = a.shift()*1;
		my.oneHandBlunt = a.shift()*1;
		my.oneHandSlash = a.shift()*1;
		my.parry = a.shift()*1;
		my.patch = a.shift();
		my.piercing = a.shift()*1;
		my.playtime = a.shift()*1;
		my.quests = a.shift()*1;
		my.race = a.shift();
		my.raresFound = a.shift()*1;
		my.riposte = a.shift()*1;
		my.setFound = a.shift()*1;
		my.sta = a.shift()*1;
		my.story = a.shift();
		my.str = a.shift()*1;
		my.subzone = a.shift()*1;
		my.subzoneN = a.shift()*1;
		my.subzoneH = a.shift()*1;
		my.svcold = a.shift()*1;
		my.svfire = a.shift()*1;
		my.svlightning = a.shift()*1;
		my.svmagic = a.shift()*1;
		my.svpoison = a.shift()*1;
		my.talent1 = a.shift()*1;
		my.talent2 = a.shift()*1;
		my.talent3 = a.shift()*1;
		my.talent4 = a.shift()*1;
		my.talent5 = a.shift()*1;
		my.talent6 = a.shift()*1;
		my.talent7 = a.shift()*1;
		my.talent8 = a.shift()*1;
		my.talent9 = a.shift()*1;
		my.talent10 = a.shift()*1;
		my.talent11 = a.shift()*1;
		my.talent12 = a.shift()*1;
		my.title = a.shift();
		my.totalGold = a.shift()*1;
		my.twoHandBlunt = a.shift()*1;
		my.twoHandSlash = a.shift()*1;
		my.uniquesFound = a.shift()*1;
		my.upgrades = a.shift()*1;
		my.wis = a.shift()*1;
		my.zone = a.shift();
		my.zoneH = a.shift();
		my.zoneN = a.shift();
		my.comboOverall = a.shift()*1;
		my.comboMistmoore = a.shift()*1;
		my.comboLowerGuk = a.shift()*1;
		my.comboCazicThule = a.shift()*1;
		my.comboKedgeKeep = a.shift()*1;
		my.comboPermafrost = a.shift()*1;
		my.comboSolB = a.shift()*1;
		my.comboPlaneofHate = a.shift()*1;
		my.comboPlaneofFear = a.shift()*1;
		my.raresSlain = a.shift()*1;
		my.views = a.shift()*1;
		srv.my = true;
		renderProfile();
	});
	$.ajax({
		url: '../php/loadData1.php',
		data:{
			run:"loadEq",
			name: name
		}
	}).done(function(data){
		var a = data.split("|");
		a.pop();
		var loops = a.length/94;
		parseItem('eq', loops, a);
		srv.eq = true;
		renderProfile();
	});
}

var srv = {
	my:false,
	eq:false
};

function zManaType(){
	var z="Mana:";
	if(my.job=="Rogue"){ 
		z="Technique Points:"; 
	}
	if(my.job=="Monk"){ 
		z="Spirit:"; 
	}
	if(my.job=="Warrior"){ 
		z="Fury Points:"; 
	}
	return z;
}
function zParryType(){
	var z = "Parry";
	if(my.job==="Monk"){ 
		z = "Block"; 
	}
	return z;
}

JOB = {};
JOB.hpTier = hpTier();
JOB.mpTier = mpTier();
JOB.mpClass = mpClass();
JOB.jobType = jobType();

function zAltType(){
	var z;
	if(my.job!=="Bard"){ 
		z="Alteration"; 
	}else{ 
		z="Singing"; 
	}
	return z;
}
function zEvoType(){
	var z;
	if(my.job!=="Bard"){ 
		z="Evocation"; 
	}else{ 
		z="Percussion"; 
	}
	return z;
}
function zConjType(){
	var z;
	if(my.job!=="Bard"){ 
		z="Conjuration"; 
	}else{ 
		z="Wind"; 
	}
	return z;
}
function zAbjType(){
	var z;
	if(my.job!=="Bard"){ 
		z="Abjuration"; 
	}else{ 
		z="String"; 
	}
	return z;
}
function zChanType(){
	var z;
	if(my.job!=="Bard"){ 
		z="Channeling"; 
	}else{ 
		z="Brass"; 
	}
	return z;
}
function zAttackHaste(display){
	var foo = M.round(attackHaste(display)*-100);
	return foo;
}
function zSkillHaste(display){
	var foo = M.round(50-((phyGlobalTotal(display)/1500)*100) );
	return foo;
}
function zCastHaste(display){
	var foo = M.round(50-((castSpeedTotal(1500, display)/1500)*100) );
	return foo;
}
g.mobDodgeChance = function(Slot){
	var miss=Slot*1.25;
	var hit=min70(dexTotal());
	miss=miss-hit;
	if(miss>30){ miss=30; }
	if(miss<5){ miss=5; }
	return miss;
}

function renderProfile(){
	if(srv.my && srv.eq){
		loadSprite();
		classSprite = new Image();
		classSprite.src = "../images1/sprite"+my.job+"3.png";
		delete my.gold;
		setEquipValues();
		g.maxHpFunct();
		g.maxMpFunct();
		dualWieldBonus = setDualWieldBonus();
		shieldBlockChance = setShieldBlockChance();
		var manaType = zManaType();
		var parryType = zParryType();
		var days = daysPlayed();
		var hours = hoursPlayed();
		function itemColor(Slot){
			var I = P.eq[Slot];
			var c = 'normal';
			if(I.rarity===1){
				c = 'magical'
			}else if(I.rarity===2){
				c = 'rare';
			}else if(I.rarity===3){
				c = 'unique';
			}else if(I.rarity===4){
				c = 'set';
			}else if(I.rarity===5){
				c = 'legendary';
			}
			return c;
		}
		var slots = [
			'Helmet',
			'Neck',
			'Ring',
			'Ring',
			'Shoulders',
			'Back',
			'Chest',
			'Bracers',
			'Gloves',
			'Belt',
			'Legs',
			'Boots',
			'Primary',
			'Secondary',
			'Range',
		];
		var JOB = "war";
		var x = my.job;
		if(x==="Rogue"){
			JOB="rog";
		}else if(x==="Monk"){
			JOB="mnk";
		}else if(x==="Paladin"){
			JOB="pal";
		}else if(x==="Shadow Knight"){
			JOB="sk";
		}else if(x==="Ranger"){
			JOB="rng";
		}else if(x==="Bard"){
			JOB="brd";
		}else if(x==="Druid"){
			JOB="dru";
		}else if(x==="Cleric"){
			JOB="clr";
		}else if(x==="Shaman"){
			JOB="shm";
		}else if(x==="Necromancer"){
			JOB="nec";
		}else if(x==="Enchanter"){
			JOB="enc";
		}else if(x==="Magician"){
			JOB="mag";
		}else if(x==="Wizard"){
			JOB="wiz";
		}
		function hardcoreMode(x){
			if(x==='false'){
				x = "Normal Mode";
			}else{
				x = "Hardcore Mode";
			}
			return x;
		}
		if(my.name===undefined){
			var s = "<div id='name'>No Character Found</div>";
		}else{
			var s =
			"<div id='profile-views'>Profile Views: "+my.views+"</div>"+
			"<div id='name'>"+my.name+' '+my.lastName+"</div>"+
			"<div id='head-level'>"+my.level+" "+my.race+" "+my.job+"</div>"+
			"<div id='head-title'>"+my.title+"</div>"+
			"<div id='head-title'>"+hardcoreMode(my.hardcoreMode)+"</div>"+
			"<div id='head-gender'>"+my.gender+"</div>"+
			// column 1
			"<div class='stat-column'>"+
				"<div class='stat-column-section'>"+
					"<h4>General</h4>"+
					"<ul>";
					if(my.hp>0){
						s+= "<li><span class='fields'>Health: </span><span class='data'>"+my.hp+" / "+my.maxHp+"</span></li>";
					}else{
						s+= "<li><span class='fields'>Health: </span><span class='reddata'>"+my.hp+" / "+my.maxHp+"</span></li>";
					}
						s+= "<li><span class='fields'>"+manaType+"</span><span class='data'>"+my.mp+" / "+my.maxMp+"</span></li>"+
						"<li><span class='fields'>Experience: </span><span class='data'>"+my.exp+"</span></li>"+
					"</ul>"+
				"</div>"+ // stat-column-section
				
				"<div class='stat-column-section'>"+
					"<h4>Attributes</h4>"+
					"<ul>"+
						"<li><span class='fields'>Strength: </span><span class='data'>"+strTotal()+"</span></li>"+
						"<li><span class='fields'>Stamina: </span><span class='data'>"+staTotal()+"</span></li>"+
						"<li><span class='fields'>Agility: </span><span class='data'>"+agiTotal()+"</span></li>"+
						"<li><span class='fields'>Dexterity: </span><span class='data'>"+dexTotal()+"</span></li>"+
						"<li><span class='fields'>Wisdom: </span><span class='data'>"+wisTotal()+"</span></li>"+
						"<li><span class='fields'>Intelligence: </span><span class='data'>"+intTotal()+"</span></li>"+
						"<li><span class='fields'>Charisma: </span><span class='data'>"+chaTotal()+"</span></li>"+
					"</ul>"+
				"</div>"+ // stat-column-section
				
				"<div class='stat-column-section'>"+
					"<h4>Offensive Statistics</h4>"+
					"<ul>"+
						"<li><span class='fields'>Hit Chance: </span><span class='data'>"+(100-g.mobDodgeChance(my.level))+"%</span></li>"+
						"<li><span class='fields'>Attack Haste: </span><span class='data'>"+zAttackHaste(true)+" | "+zAttackHaste(false)+"%</span></li>"+
						"<li><span class='fields'>Skill Haste: </span><span class='data'>"+zSkillHaste(true)+" | "+zSkillHaste(false)+"%</span></li>"+
						"<li><span class='fields'>Casting Haste:</span><span class='data'>"+zCastHaste(true)+" | "+zCastHaste(false)+"%</span></li>"+
						"<li><span class='fields'>Critical Chance: </span><span class='data'>"+fix(criticalChance(true))+" | "+fix(criticalChance()*100)+"%</span></li>"+
						"<li><span class='fields'>Critical Damage: </span><span class='data'>"+fix(g.criticalDamage()*100)+"%</span></li>"+
						"<li><span class='fields'>Thorns: </span><span class='data'>"+g.thornsEquip+"</span></li>"+
					"</ul>"+
				"</div>"+ // stat-column-section
				
				"<div class='stat-column-section'>"+
					"<h4>Enhanced Damage</h4>"+
					"<ul>"+
						"<li><span class='fields'>Physical: </span><span class='data'>"+g.enhancePhysicalEquip+"</span></li>"+
						"<li><span class='fields'>Poison: </span><span class='data'>"+(g.enhancePoisonEquip+g.enhanceAllEquip)+"</span></li>"+
						"<li><span class='fields'>Arcane: </span><span class='data'>"+(g.enhanceMagicEquip+g.enhanceAllEquip)+"</span></li>"+
						"<li><span class='fields'>Lightning:</span><span class='data'>"+(g.enhanceLightningEquip+g.enhanceAllEquip)+"</span></li>"+
						"<li><span class='fields'>Cold: </span><span class='data'>"+(g.enhanceColdEquip+g.enhanceAllEquip)+"</span></li>"+
						"<li><span class='fields'>Fire: </span><span class='data'>"+(g.enhanceFireEquip+g.enhanceAllEquip)+"</span></li>"+
					"</ul>"+
				"</div>"+ // stat-column-section
				
				"<div class='stat-column-section'>"+
					"<h4>Resists</h4>"+
					"<ul>"+
						"<li><span class='fields'>Resist Poison: </span><span class='data'>"+poisonTotal()+"</span></li>"+
						"<li><span class='fields'>Resist Arcane:</span><span class='data'>"+magicTotal()+"</span></li>"+
						"<li><span class='fields'>Resist Lightning: </span><span class='data'>"+lightningTotal()+"</span></li>"+
						"<li><span class='fields'>Resist Cold: </span><span class='data'>"+coldTotal()+"</span></li>"+
						"<li><span class='fields'>Resist Fire: </span><span class='data'>"+fireTotal()+"</span></li>"+
					"</ul>"+
				"</div>"+ // stat-column-section
				
				"<div class='stat-column-section'>"+
					"<h4>Absorption:</h4>"+
					"<ul>"+
						"<li><span class='fields'>Poison: </span><span class='data'>"+g.absorbPoisonEquip+"%</span></li>"+
						"<li><span class='fields'>Arcane:</span><span class='data'>"+g.absorbMagicEquip+"%</span></li>"+
						"<li><span class='fields'>Lightning: </span><span class='data'>"+g.absorbLightningEquip+"%</span></li>"+
						"<li><span class='fields'>Cold: </span><span class='data'>"+g.absorbColdEquip+"%</span></li>"+
						"<li><span class='fields'>Fire: </span><span class='data'>"+g.absorbFireEquip+"%</span></li>"+
					"</ul>"+
				"</div>"+ // stat-column-section
				
				"<div class='stat-column-section'>"+
					"<h4>Conquests</h4>"+
					"<ul>"+
						"<li><span class='fields'>Play Time: </span><span class='data'>"+daysPlayed()+" Days, "+hoursPlayed()+" Hours</span></li>"+
						"<li><span class='fields'>Kills: </span><span class='data'>"+my.mobsSlain+"</span></li>"+
						"<li><span class='fields'>Deaths: </span><span class='data'>"+my.deaths+"</span></li>"+
						"<li><span class='fields'>Champion Kills:</span><span class='data'>"+my.championsSlain+"</span></li>"+
						"<li><span class='fields'>Rare Kills: </span><span class='data'>"+my.raresSlain+"</span></li>"+
						"<li><span class='fields'>Boss Kills: </span><span class='data'>"+my.epicQuests+"</span></li>"+
						"<li><span class='fields'>Escapes: </span><span class='data'>"+my.escapes+"</span></li>"+
						"<li><span class='fields'>Magic Items Found: </span><span class='data'>"+my.magicFound+"</span></li>"+
						"<li><span class='fields'>Rare Items Found: </span><span class='data'>"+my.raresFound+"</span></li>"+
						"<li><span class='fields'>Unique Items Found: </span><span class='data'>"+my.uniquesFound+"</span></li>"+
						"<li><span class='fields'>Set Items Found: </span><span class='data'>"+my.setFound+"</span></li>"+
						"<li><span class='fields'>Best Combo Rating: </span><span class='data'>"+my.comboOverall+"</span></li>"+
						"<li><span class='fields'>Quests Completed: </span><span class='data'>"+my.quests+"</span></li>"+
					"</ul>"+
				"</div>"+ // stat-column-section
				
				"<div class='stat-column-section'>"+
					relatedCharacters+
				"</div>"+
				
			"</div>"+ // COLUMN 1
			// COLUMN 2
			"<div class='stat-column'>"+
				"<div class='stat-column-section'>"+
					"<h4>Skills</h4>"+
					"<ul>"+
						"<li><span class='fields'>One-hand Slashing: </span><span class='data'>"+oneHandSlashTotal()+"</span></li>"+
						"<li><span class='fields'>Two-hand Slashing:</span><span class='data'>"+twoHandSlashTotal()+"</span></li>"+
						"<li><span class='fields'>One-hand Blunt: </span><span class='data'>"+oneHandBluntTotal()+"</span></li>"+
						"<li><span class='fields'>Two-hand Blunt: </span><span class='data'>"+twoHandBluntTotal()+"</span></li>"+
						"<li><span class='fields'>Piercing: </span><span class='data'>"+piercingTotal()+"</span></li>"+
						"<li><span class='fields'>Hand to Hand: </span><span class='data'>"+handToHandTotal()+"</span></li>"+
						"<li><span class='fields'>Offense: </span><span class='data'>"+offenseTotal()+"</span></li>"+
						"<li><span class='fields'>Dual Wield: </span><span class='data'>"+dualWieldTotal()+"</span></li>"+
						"<li><span class='fields'>Double Attack: </span><span class='data'>"+doubleAttackTotal()+"</span></li>"+
						"<li><span class='fields'>Defense: </span><span class='data'>"+defenseTotal()+"</span></li>"+
						"<li><span class='fields'>Dodge: </span><span class='data'>"+dodgeTotal()+"</span></li>"+
						"<li><span class='fields'>"+parryType+": </span><span class='data'>"+parryTotal()+"</span></li>"+
						"<li><span class='fields'>Riposte: </span><span class='data'>"+riposteTotal()+"</span></li>"+
						"<li><span class='fields'>"+zAltType()+": </span><span class='data'>"+alterationTotal()+"</span></li>"+
						"<li><span class='fields'>"+zEvoType()+": </span><span class='data'>"+evocationTotal()+"</span></li>"+
						"<li><span class='fields'>"+zConjType()+": </span><span class='data'>"+conjurationTotal()+"</span></li>"+
						"<li><span class='fields'>"+zAbjType()+": </span><span class='data'>"+abjurationTotal()+"</span></li>"+
						"<li><span class='fields'>"+zChanType()+": </span><span class='data'>"+channelingTotal()+"</span></li>"+
					"</ul>"+
				"</div>"+ // stat-column-section
				
				"<div class='stat-column-section'>"+
					"<h4>Swordsmanship</h4>"+
					"<ul>"+
						"<li><span class='fields'>Dual Wield Chance: </span><span class='data'>"+dualWieldChance().toFixed(1)+"%</span></li>"+
						"<li><span class='fields'>Double Attack Chance: </span><span class='data'>"+doubleAttackChance().toFixed(1)+"%</span></li>"+
						"<li><span class='fields'>Parry Chance: </span><span class='data'>"+parryChance().toFixed(1)+"%</span></li>"+
						"<li><span class='fields'>Riposte Chance:</span><span class='data'>"+riposteChance().toFixed(1)+"%</span></li>"+
					"</ul>"+
				"</div>"+ // stat-column-section
				
				"<div class='stat-column-section'>"+
					"<h4>Added Melee Damage</h4>"+
					"<ul>"+
						"<li><span class='fields'>Physical Damage: </span><span class='data'>"+g.physicalDamageEquip+"</span></li>"+
						"<li><span class='fields'>Poison Damage: </span><span class='data'>"+g.poisonDamageEquip+"</span></li>"+
						"<li><span class='fields'>Arcane Damage: </span><span class='data'>"+g.magicDamageEquip+"</span></li>"+
						"<li><span class='fields'>Lightning Damage:</span><span class='data'>"+g.lightningDamageEquip+"</span></li>"+
						"<li><span class='fields'>Cold Damage: </span><span class='data'>"+g.coldDamageEquip+"</span></li>"+
						"<li><span class='fields'>Fire Damage: </span><span class='data'>"+g.fireDamageEquip+"</span></li>"+
					"</ul>"+
				"</div>"+ // stat-column-section
				
				"<div class='stat-column-section'>"+
					"<h4>Defensive Stats:</h4>"+
					"<ul>"+
						"<li><span class='fields'>Shield Block Chance: </span><span class='data'>"+~~(shieldBlockChance*100)+"%</span></li>"+
						"<li><span class='fields'>Dodge Chance: </span><span class='data'>"+dodgeChance().toFixed(1)+"%</span></li>"+
						"<li><span class='fields'>Physical Reduction:</span><span class='data'>"+physicalMitigation()+"</span></li>"+
						"<li><span class='fields'>Magical Reduction: </span><span class='data'>"+magicMitigation()+"</span></li>"+
						"<li><span class='fields'>Life Leech Rating: </span><span class='data'>"+~~(g.leechEquip*100)+"</span></li>"+
						"<li><span class='fields'>Mana Leech Rating: </span><span class='data'>"+~~(g.wraithEquip)+"</span></li>"+
						"<li><span class='fields'>Health Per Kill: </span><span class='data'>"+g.hpKillEquip+"</span></li>"+
						"<li><span class='fields'>Mana Per Kill: </span><span class='data'>"+g.mpKillEquip+"</span></li>"+
						"<li><span class='fields'>Health Regeneration: </span><span class='data'>"+g.hpRegenEquip+"</span></li>"+
						"<li><span class='fields'>Mana Regeneration: </span><span class='data'>"+g.mpRegenEquip+"</span></li>"+
						"<li><span class='fields'>Run Speed: </span><span class='data'>"+g.runSpeedEquip+"%</span></li>"+
						"<li><span class='fields'>Fear Reduction: </span><span class='data'>"+g.fearEquip+"%</span></li>"+
						"<li><span class='fields'>Stun Reduction: </span><span class='data'>"+g.stunEquip+"%</span></li>"+
						"<li><span class='fields'>Chill Reduction: </span><span class='data'>"+g.chillEquip+"%</span></li>"+
						"<li><span class='fields'>Silence Reduction: </span><span class='data'>"+g.silenceEquip+"%</span></li>"+
					"</ul>"+
				"</div>"+ // stat-column-section
				
				"<div class='stat-column-section'>"+
					"<h4>Providence</h4>"+
					"<ul>"+
						"<li><span class='fields'>Gold Gain: </span><span class='data'>"+g.goldFindEquip+"%</span></li>"+
						"<li><span class='fields'>Exp Gain: </span><span class='data'>"+g.expFindEquip+"%</span></li>"+
						"<li><span class='fields'>Magic Find: </span><span class='data'>"+g.lightRadiusEquip+"</span></li>"+
					"</ul>"+
				"</div>"+ // stat-column-section
				
				"<div class='stat-column-section'>"+
					relatedJobs+
				"</div>"+
				
			"</div>"+ // COLUMN 2 
			
			// COLUMN 3
			"<div id='column3' class='stat-column'>"+
				
				"<div class='stat-column-section'>"+
					"<h4>Equipment</h4>"+
					"<table id='equipTable'>";
						for(var i=0;i<=14;i++){
							s+= "<tr><td>"+
									"<div class='itemImgBg' data-item='"+i+"'>";
										if(P.eq[i].rarity>=3){
											var x = P.eq[i].name; 
											var z = x.replace(/ /g, '_');
											z = z.replace(/'/g, '%27');
											s+= '<a target="_blank" title="'+P.eq[i].name+'" alt="'+P.eq[i].name+'" href="https://nevergrind.com/wiki/index.php?title='+z+'">';
										}
										s+= "<img class='itemImg' src='../images1/item-ng.png' style='left:"+P.eq[i].xPos+"px;top:"+P.eq[i].yPos+"px'>";
										if(P.eq[i].rarity>=3){
											s+= "</a>";
										}
									s+= "</div>"+
								"</td>"+
								"<td class='data items "+itemColor(i)+"'>";
									if(P.eq[i].name===''){
										if(i===12||i===13){
											s+= "Fists";
										}else{
											s+= "Empty";
										}
									}else{
										s+= P.eq[i].name;
									}
									s+= "<span class='valign'></span>"+
								"</td></tr>";
						}
					s+= "</table>"+
				"</div>"+ // stat-column-section
				
				"<div class='stat-column-section'>"+
					"<h4>Talents</h4>"+
					
					
					"<table id='talentTable'>";
						var urlJob = my.job.replace(/ /g, "%20");
						for(var i=1;i<=12;i++){
							s+= "<tr><td class='talentWrap'>"+
									"<div class='talentImgBg' style='background-image: url(https://nevergrind.com/images1/sprite"+urlJob+"3.png); background-position:-"+window[JOB].tx[i]+"px "+window[JOB].ty[i]+"px;'></div>"+
									"<div class='talentNum strongShadow'>"+window['talent'+i]()+"</div>"+
								"</td>"+
								"<td class='talent'>"+
									window[JOB].tal[i]+
							"</td></tr>";
						}
					s+= "</table>"+
				"</div>"+ // stat-column-section
				
			"</div>"+ // COLUMN 3 
			
			"<div class='clearLeft'></div>";
		}
		document.getElementById('characterWrap').innerHTML = s;
	}
}
function displayItem(Slot){
	var x = P.eq[Slot].name;
	if(P.eq[Slot].rarity>=3){
		var z=x.replace(/ /g, '_');
		z = z.replace(/'/g, '%27');
		return "<a target='_blank' href='https://nevergrind.com/wiki/index.php?title="+z+"'>"+x;
	}else{
		if(x===''){
			if(Slot===12||Slot===13){
				return "Fists";
			}else{
				return "No Item Equipped";
			}
		}else{
			return x;
		}
	}
}
function loadSprite(){
	// load class sprites
}

dropSlot=0;
mouseTTX=0;
mouseTTY=0;
TweenMax.set(NG.ttItem, {
	transformPerspective:400
})
$(document).ready(function(){
	$(".content").on('mouseenter', ".itemImgBg", function(){
		dropSlot = $(this).data('item');
		if(!P.eq[dropSlot].name){
			return;
		}
		showTooltip(dropSlot);
		// position Y
		var y1 = $("#ttItem").height();
		var y2 = window.scrollY+10;
		var Y = y2;
		if(y1+y2 < mouseTTY){
			var adj = mouseTTY - (y1+y2) + 64;
			Y += adj;
			
			var ttt = (scrollY+y1+adj);
			var max = (scrollY + window.innerHeight);
			if(ttt+15 > max){
				Y = scrollY + window.innerHeight - 10 - y1;
			}
		}
		TweenMax.to(NG.ttItem, .125, {
			opacity:1
		});
		NG.ttItem.style.top = Y+'px';
		NG.ttItem.style.display='block';
	}).on('mouseleave', ".itemImgBg", function(){
		TweenMax.to(NG.ttItem, .25, {
			opacity:0,
			onComplete:function(){
				NG.ttItem.style.display='none';
			}
		});
	});
	$("body").on('mousemove', function(e){
		mouseTTY = e.pageY;
	})
});